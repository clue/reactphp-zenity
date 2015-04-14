<?php

use Clue\React\Zenity\Launcher;
use React\EventLoop\Factory;
use Clue\React\Zenity\Zen\BaseZen;

class LauncherTest extends TestCase
{
    private $loop;
    private $dialog;
    private $launcher;

    public function setUp()
    {
        $this->loop = Factory::create();

        $this->dialog = $this->getMock('Clue\React\Zenity\Dialog\AbstractDialog');
        $this->dialog->expects($this->once())->method('createZen')->will($this->returnValue(new BaseZen()));

        $this->launcher = new Launcher($this->loop);
    }

    public function testEchoParameters()
    {
        $this->launcher->setBin('echo');
        $this->dialog->expects($this->once())->method('getArgs')->will($this->returnValue(array('--hello', '--world')));

        $promise = $this->launcher->launch($this->dialog);

        $this->loop->run();

        $promise->then($this->expectCallableOnceWith('--hello --world'));
    }

    public function testDoesPassStdin()
    {
        $this->launcher->setBin('cat');
        $this->dialog->expects($this->once())->method('getArgs')->will($this->returnValue(array()));
        $this->dialog->expects($this->once())->method('getInBuffer')->will($this->returnValue('okay'));

        $zen = $this->launcher->launchZen($this->dialog);

        $this->loop->addTimer(0.1, function () use ($zen) {
            $zen->close();
        });

        $this->loop->run();

        $zen->promise()->then($this->expectCallableOnceWith('okay'));
    }

    public function testWaitForOutput()
    {
        $this->launcher->setBin('echo');
        $this->dialog->expects($this->once())->method('getArgs')->will($this->returnValue(array('test')));

        $result = $this->launcher->waitFor($this->dialog);

        $this->assertEquals('test', $result);
    }

    public function testWaitForError()
    {
        $this->launcher->setBin('false');
        $this->dialog->expects($this->once())->method('getArgs')->will($this->returnValue(array()));

        $result = $this->launcher->waitFor($this->dialog);

        $this->assertEquals(false, $result);
    }
}