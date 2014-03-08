<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Launcher;
use React\Promise\PromiseInterface;
use React\Promise\Deferred;

abstract class AbstractDialog implements PromiseInterface
{
    private $launcher;
    private $deferred;
    private $inbuffer;
    protected $process;

    protected $title;
    protected $windowIcon;
    protected $timeout;
    protected $modal = false;
    protected $width;
    protected $height;
    protected $okLabel;
    protected $cancelLabel;

    public function __construct(Launcher $launcher)
    {
        $this->launcher = $launcher;
        $this->deferred = new Deferred();
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function setWindowIcon($icon)
    {
        $this->windowIcon = $icon;

        return $this;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = (int)$timeout;

        return $this;
    }

    public function setModal($modal)
    {
        $this->modal = !!$modal;

        return $this;
    }

    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    public function setOkLabel($label)
    {
        $this->okLabel = $label;

        return $this;
    }

    public function setCancelLabel($label)
    {
        $this->cancelLabel = $label;

        return $this;
    }

    public function run()
    {
        if ($this->process !== null) {
            return $this;
        }

        $args = $this->getArgs();

        $this->process = $process = $this->launcher->run($args);

        if ($this->inbuffer !== null) {
            $process->inputStream()->write($this->inbuffer);
            $this->inbuffer = null;
        }

        $result = null;
        $process->outputStream()->on('data', function ($data) use (&$result) {
            if ($data !== '') {
                $result .= $data;
            }
        });

        $deferred = $this->deferred;
        $that = $this;
        $process->outputStream()->on('end', function() use ($process, &$result, $that, $deferred) {
            $code = $process->status()->exitCode();
            if ($code !== 0) {
                $deferred->reject($code);
            } else {
                if ($result === null) {
                    $result = true;
                } else {
                    $result = $that->parseValue(trim($result));
                }
                $deferred->resolve($result);
            }

            $that->close();
        });

        return $this;
    }

    /**
     * Block while waiting for this dialog to return
     *
     * If the dialog is already closed, this returns immediately, without doing
     * much at all. If the dialog is not yet opened, it will be opened and this
     * method will wait for the dialog to be handled (i.e. either completed or
     * closed). Clicking "ok" will result in a boolean true value, clicking
     * "cancel" or hitten escape key will or running into a timeout will result
     * in a boolean false. For all other input fields, their respective (parsed)
     * value will be returned.
     *
     * For this to work, this method will temporarily start the event loop and
     * stop it afterwards. Thus, it is *NOT* a good idea to mix this if anything
     * else is listening on the event loop. The recommended way in this case is
     * to avoid using this blocking method call and go for a fully async
     * `self::then()` instead.
     *
     * @return boolean|string dialog return value
     * @uses Launcher::waitFor()
     */
    public function waitReturn()
    {
        return $this->launcher->waitFor($this);
    }

    public function getType()
    {
        return $this->decamelize(basename(str_replace('\\', '/', get_class($this))));
    }

    public function getArgs()
    {

        $args = array(
            '--' . $this->getType()
        );

        foreach ($this as $name => $value) {
            if (!in_array($name, array('deferred', 'result', 'process', 'launcher', 'inbuffer')) && $value !== null && $value !== false && !is_array($value)) {
                $name = $this->decamelize($name);

                if ($name === true) {
                    $args[] = $value;
                } else {
                    $args[$name] = $value;
                }
            }
        }

        return $args;
    }

    protected function decamelize($name)
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $name));
    }

    public function parseValue($value)
    {
        return $value;
    }

    public function then($fulfilledHandler = null, $errorHandler = null, $progressHandler = null)
    {
        if ($this->process === null) {
            $this->run();
        }
        return $this->deferred->then($fulfilledHandler, $errorHandler, $progressHandler);
    }

    public function close()
    {
        if ($this->process !== null) {
            $this->process->kill();

            $streams = array($this->process->outputStream(), $this->process->inputStream(), $this->process->errorStream());
            foreach ($streams as $stream) {
                if ($stream !== null) {
                    $stream->close();
                }
            }

            // $this->process = null;
        }

        return $this;
    }

    protected function writeln($line)
    {
        if ($this->process !== null) {
            $this->process->inputStream()->write($line . PHP_EOL);
        } else {
            // process not yet started => buffer input stream temporarily
            $this->inbuffer .= $line . PHP_EOL;
        }
    }
}
