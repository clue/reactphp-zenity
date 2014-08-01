<?php

namespace Clue\React\Zenity;

use React\EventLoop\LoopInterface;
use Icecave\Mephisto\Factory\ProcessFactory;
use Icecave\Mephisto\Launcher\CommandLineLauncher;
use Icecave\Mephisto\Process\ProcessInterface;
use Clue\React\Zenity\Dialog\AbstractDialog;
use React\Promise\Deferred;

/**
 *
 * @link https://github.com/clue/zenity-react
 * @link https://help.gnome.org/users/zenity/stable/index.html.en
 */
class Launcher
{
    private $loop;
    private $processLauncher;
    private $bin = 'zenity';

    public function __construct(LoopInterface $loop, CommandLineLauncher $processLauncher = null)
    {
        if ($processLauncher === null) {
            $processFactory = new ProcessFactory($loop);
            $processLauncher = new CommandLineLauncher($processFactory);
        }

        $this->processLauncher = $processLauncher;
        $this->loop = $loop;
    }

    public function setBin($bin)
    {
        $this->bin = $bin;

        return $this;
    }

    public function launch(AbstractDialog $dialog)
    {
        $process = $this->createProcess($dialog);

        $inbuffer = $dialog->getInBuffer();
        if ($inbuffer !== null) {
            $process->inputStream()->write($inbuffer);
        }

        $deferred = new Deferred();

        $result = null;
        $process->outputStream()->on('data', function ($data) use (&$result) {
            if ($data !== '') {
                $result .= $data;
            }
        });

        $zen = $dialog->createZen($deferred, $process);

        $process->outputStream()->on('end', function() use ($process, $zen, &$result, $dialog, $deferred) {
            $code = $process->status()->exitCode();
            if ($code !== 0) {
                $deferred->reject($code);
            } else {
                if ($result === null) {
                    $result = true;
                } else {
                    $result = $dialog->parseValue(trim($result));
                }
                $deferred->resolve($result);
            }

            $zen->close();
        });

        return $zen;
    }

    /**
     * Block while waiting for the given dialog to return
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
     * @param AbstractDialog $dialog
     * @return boolean|string dialog return value
     * @uses Launcher::waitFor()
     */
    public function waitFor(AbstractDialog $dialog)
    {
        $done = false;
        $ret  = null;
        $loop = $this->loop;

        $process = $this->launch($dialog);

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

    private function createProcess(AbstractDialog $dialog)
    {
        return $this->run($dialog->getArgs());
    }

    private function run(array $args = array())
    {
        $command = $this->bin;

        foreach ($args as $name => $value) {
            if (is_int($name)) {
                $command .= ' ' . escapeshellarg($value);
            } else {
                $command .= ' --' . $name . '=' . escapeshellarg($value);
            }
        }

        // var_dump($command);

        $process = $this->processLauncher->runCommandLine($command);
        /* @var $process ProcessInterface */
        return $process;
    }
}
