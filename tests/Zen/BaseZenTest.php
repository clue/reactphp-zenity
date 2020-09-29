<?php

use Clue\React\Zenity\Zen\BaseZen;
use React\EventLoop\Factory;
use React\ChildProcess\Process;
use Clue\Tests\React\Zenity\TestCase;

abstract class BaseZenTest extends TestCase
{
    protected $instream;
    protected $process;
    protected $stdin = '';

    /**
     * @before
     */
    public function setUpMocks()
    {
        $inbuffer =& $this->stdin;
        $this->instream = $this->getMockBuilder('React\Stream\WritableStreamInterface')->getMock();
        $this->instream->expects($this->any())->method('write')->will($this->returnCallback(function ($value) use (&$inbuffer) {
            $inbuffer .= $value;
        }));

        $this->process = $this->getMockBuilder('React\ChildProcess\Process')->disableOriginalConstructor()->getMock();
        $this->process->stdin = $this->instream;

        $this->process->stdout = $this->getMockBuilder('React\Stream\ReadableStreamInterface')->getMock();
        $this->process->stderr = $this->getMockBuilder('React\Stream\ReadableStreamInterface')->getMock();
    }

    public function testClosingZenTerminatesProcess()
    {
        $this->process->expects($this->once())->method('isRunning')->will($this->returnValue(true));
        $this->process->expects($this->once())->method('terminate');

        $zen = new BaseZen();
        $zen->go($this->process);

        $zen->close();
    }
}
