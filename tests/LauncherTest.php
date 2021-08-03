<?php

namespace Clue\Tests\React\Zenity;

use Clue\React\Zenity\Launcher;

class LauncherTest extends TestCase
{
    public function testConstructWithoutLoopAssignsLoopAutomatically()
    {
        $launcher = new Launcher();

        $ref = new \ReflectionProperty($launcher, 'loop');
        $ref->setAccessible(true);
        $loop = $ref->getValue($launcher);

        $this->assertInstanceOf('React\EventLoop\LoopInterface', $loop);
    }
}
