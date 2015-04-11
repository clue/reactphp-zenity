<?php

use React\EventLoop\Factory;
use React\ChildProcess\Process;
use Clue\React\Zenity\Zen\BaseZen;
class FunctionalBaseZenTest extends TestCase
{
    public function setUp()
    {
        $this->loop = Factory::create();
    }

    public function testZenResolvesWithProcessOutput()
    {
        $process = new Process('echo okay');
        $process->start($this->loop);

        $zen = new BaseZen();
        $zen->go($process);

        $this->loop->run();

        $zen->then($this->expectCallableOnceWith('okay'));
    }

    public function testZenResolvesWithTrueWhenProcessHasNoOutput()
    {
        $process = new Process('true');
        $process->start($this->loop);

        $zen = new BaseZen();
        $zen->go($process);

        $this->loop->run();

        $zen->then($this->expectCallableOnceWith(true));
    }

    public function testZenRejectsWhenProcessReturnsError()
    {
        $process = new Process('echo nevermind && false');
        $process->start($this->loop);

        $zen = new BaseZen();
        $zen->go($process);

        $this->loop->run();

        $zen->then(null, $this->expectCallableOnceWith(1));
    }

    public function testClosingZenResolvesWithOutputSoFar()
    {
        $process = new Process('echo okay && cat && echo not');
        $process->start($this->loop);

        $zen = new BaseZen();
        $zen->go($process);

        $this->loop->addTimer(0.1, function() use ($zen) {
            $zen->close();
        });

        $this->loop->run();

        $zen->then($this->expectCallableOnceWith('okay'));
    }

    public function testTerminatingProcessReturnsError()
    {
        $process = new Process('echo nevermind && cat');
        $process->start($this->loop);

        $zen = new BaseZen();
        $zen->go($process);

        $this->loop->addTimer(0.1, function() use ($process) {
            $process->terminate(SIGKILL);
        });

        $this->loop->run();

        $zen->then(null, $this->expectCallableOnce());
    }
}
