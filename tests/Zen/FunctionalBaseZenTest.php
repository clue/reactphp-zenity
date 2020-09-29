<?php

use Clue\React\Block;
use Clue\React\Zenity\Zen\BaseZen;
use React\EventLoop\Factory;
use React\ChildProcess\Process;
use Clue\Tests\React\Zenity\TestCase;

class FunctionalBaseZenTest extends TestCase
{
    /**
     * @before
     */
    public function setUpLoop()
    {
        $this->loop = Factory::create();
    }

    public function testZenResolvesWithProcessOutput()
    {
        $process = new Process('echo okay');
        $process->start($this->loop);

        $zen = new BaseZen();
        $zen->go($process);

        $result = Block\await($zen->promise(), $this->loop, 1.0);

        $this->assertEquals('okay', $result);
    }

    public function testZenResolvesWithTrueWhenProcessHasNoOutput()
    {
        $process = new Process('true');
        $process->start($this->loop);

        $zen = new BaseZen();
        $zen->go($process);

        $result = Block\await($zen->promise(), $this->loop, 1.0);

        $this->assertTrue($result);
    }

    public function testZenRejectsWhenProcessReturnsError()
    {
        $process = new Process('echo nevermind && false');
        $process->start($this->loop);

        $zen = new BaseZen();
        $zen->go($process);

        Block\await($zen->promise()->then(null, $this->expectCallableOnceWith(1)), $this->loop, 1.0);
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

        $result = Block\await($zen->promise(), $this->loop, 1.0);

        $this->assertEquals('okay', $result);
    }

    public function testTerminatingProcessReturnsError()
    {
        $process = new Process('echo nevermind && cat');
        $process->start($this->loop);

        $zen = new BaseZen();
        $zen->go($process);

        $this->loop->addTimer(0.1, function() use ($process) {
            $process->terminate(SIGKILL);
            $process->stdin->end();
        });

        Block\await($zen->promise()->then(null, $this->expectCallableOnce()), $this->loop, 1.0);
    }
}
