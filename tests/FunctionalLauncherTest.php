<?php

use Clue\React\Block;
use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Zen\BaseZen;
use React\EventLoop\Factory;

class FunctionalLauncherTest extends TestCase
{
    private $loop;
    private $dialog;
    private $launcher;

    public function setUp()
    {
        $this->loop = Factory::create();

        $this->dialog = $this->getMockBuilder('Clue\React\Zenity\Dialog\AbstractDialog')->getMock();
        $this->dialog->expects($this->once())->method('createZen')->will($this->returnValue(new BaseZen()));

        $this->launcher = new Launcher($this->loop);
    }

    public function testEchoParameters()
    {
        $this->launcher->setBin('echo');
        $this->dialog->expects($this->once())->method('getArgs')->will($this->returnValue(array('--hello', '--world')));

        $promise = $this->launcher->launch($this->dialog);

        $result = Block\await($promise, $this->loop, 1.0);

        $this->assertEquals('--hello --world', $result);
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

        $result = Block\await($zen->promise(), $this->loop, 1.0);

        $this->assertEquals('okay', $result);
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