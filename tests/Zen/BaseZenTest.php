<?php

use Clue\React\Zenity\Zen\BaseZen;
abstract class BaseZenTest extends TestCase
{
    protected $instream;
    protected $process;
    protected $promise;
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

        $this->promise = $this->getMock('React\Promise\PromiseInterface');
    }

    public function testClose()
    {
        //$this->instream->expects($this->once())->method('close');

        $zen = new BaseZen();
        $zen->go($this->promise, $this->process);

        $zen->close();
    }

    public function testThen()
    {
        $this->promise->expects($this->once())->method('then');

        $zen = new BaseZen();
        $zen->go($this->promise, $this->process);

        $zen->then();
    }
}
