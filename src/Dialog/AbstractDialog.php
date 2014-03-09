<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Launcher;
use React\Promise\PromiseInterface;
use React\Promise\Deferred;
use Icecave\Mephisto\Process\ProcessInterface;
use Clue\React\Zenity\Zen\BaseZen;

abstract class AbstractDialog
{
    private $launcher;
    private $inbuffer = null;

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
        $process = $this->launcher->createProcess($this);

        if ($this->inbuffer !== null) {
            $process->inputStream()->write($this->inbuffer);
        }

        $deferred = new Deferred();

        $result = null;
        $process->outputStream()->on('data', function ($data) use (&$result) {
            if ($data !== '') {
                $result .= $data;
            }
        });

        $that = $this;

        $zen = $this->createZen($deferred, $process);

        $process->outputStream()->on('end', function() use ($process, $zen, &$result, $that, $deferred) {
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

            $zen->close();
        });

        return $zen;
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
        $done = false;
        $ret  = null;
        $loop = $this->loop;

        $process = $this->launch();

        $process->then(function ($result) use (&$ret, &$done, $loop) {
            $ret = $result;
            $done = true;

            $loop->stop();
        }, function () use (&$ret, &$done, $loop) {
            $ret = false;
            $done = true;

            $loop->stop();
        });

        if (!$done) {
            $loop->run();
        }

        return $ret;
    }

    private function getType()
    {
        // InfoDialog => info
        return $this->decamelize(substr(basename(str_replace('\\', '/', get_class($this))), 0, -6));
    }

    public function getArgs()
    {

        $args = array(
            '--' . $this->getType()
        );

        foreach ($this as $name => $value) {
            if (!in_array($name, array('inbuffer', 'launcher')) && $value !== null && $value !== false && !is_array($value)) {
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

    protected function createZen(Deferred $deferred, ProcessInterface $process)
    {
        return new BaseZen($deferred, $process);
    }

    protected function writeln($line)
    {
        // buffer input stream temporarily
        $this->inbuffer .= $line . PHP_EOL;
    }
}
