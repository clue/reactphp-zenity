<?php

namespace Clue\Zenity\React;

use React\EventLoop\LoopInterface;
use Icecave\Mephisto\Factory\ProcessFactory;
use Icecave\Mephisto\Launcher\CommandLineLauncher;
use Icecave\Mephisto\Process\ProcessInterface;

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
    }

    public function run($args = array())
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

    public function wait(Zenity $zenity)
    {
        $done = false;
        $ret  = null;
        $loop = $this->loop;

        $zenity->then(function ($result) use (&$ret, &$done, $loop) {
            $ret = $result;
            $done = true;

            $loop->stop();
        });

        if (!$done) {
            $zenity->run($this);

            $loop->run();
        }

        return $ret;
    }
}
