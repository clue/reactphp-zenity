<?php

use Clue\React\Zenity\Zen\BaseZen;
use React\EventLoop\Factory;
use React\ChildProcess\Process;

abstract class BaseZenTest extends TestCase
{
    protected $instream;
    protected $process;
    protected $stdin = '';

    public function setUp()
    {
        $inbuffer =& $this->stdin;
        $this->instream = $this->getMock('React\Stream\WritableStreamInterface');
        $this->instream->expects($this->any())->method('write')->will($this->returnCallback(function ($value) use (&$inbuffer) {
            $inbuffer .= $value;
        }));

        $this->process = $this->getMockBuilder('React\ChildProcess\Process')->disableOriginalConstructor()->getMock();
        $this->process->stdin = $this->instream;

        $this->process->stdout = $this->getMock('React\Stream\ReadableStreamInterface');
    }

    public function testClose()
    {
        $zen = new BaseZen();
        $zen->go($this->process);

        $zen->close();
    }
}
