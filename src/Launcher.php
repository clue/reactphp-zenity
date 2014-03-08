<?php

namespace Clue\React\Zenity;

use React\EventLoop\LoopInterface;
use Icecave\Mephisto\Factory\ProcessFactory;
use Icecave\Mephisto\Launcher\CommandLineLauncher;
use Icecave\Mephisto\Process\ProcessInterface;
use Clue\React\Zenity\Dialog\AbstractDialog;

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

    public function run(array $args = array())
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

    /**
     * Block while waiting for $zenity dialog to return
     *
     * This method should not be called manually! Use AbstractDialog::waitReturn() instead!
     *
     * @param AbstractDialog $zenity
     * @return unknown
     * @private
     * @see AbstractDialog::waitReturn() instead
     */
    public function waitFor(AbstractDialog $zenity)
    {
        $done = false;
        $ret  = null;
        $loop = $this->loop;

        $zenity->then(function ($result) use (&$ret, &$done, $loop) {
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
}
