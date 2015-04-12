<?php

use Clue\React\Zenity\Zen\ProgressZen;

class ProgressZenTest extends BaseZenTest
{
    public function testPercentage()
    {
        $zen = new ProgressZen(0);
        $zen->go($this->process);

        $this->assertEquals(0, $zen->getPercentage());

        $this->assertSame($zen, $zen->setPercentage(20));
        $this->assertEquals(20, $zen->getPercentage());

        $this->assertSame($zen, $zen->setText('hello'));

        $this->assertSame($zen, $zen->advance(30));
        $this->assertEquals(50, $zen->getPercentage());

        $this->assertSame($zen, $zen->setText('world'));

        $this->assertSame($zen, $zen->complete());
        $this->assertEquals(100, $zen->getPercentage());

        $this->assertEquals('20' . PHP_EOL . '#hello' . PHP_EOL . '50' . PHP_EOL . '#world' . PHP_EOL . '100' . PHP_EOL, $this->stdin);
    }
}
