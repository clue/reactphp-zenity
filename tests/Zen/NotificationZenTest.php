<?php

use Clue\React\Zenity\Zen\NotificationZen;

class NotificationZenTest extends BaseZenTest
{
    public function testCommands()
    {
        $zen = new NotificationZen();
        $zen->go($this->promise, $this->process);

        $this->assertSame($zen, $zen->setIcon('icon'));
        $this->assertSame($zen, $zen->setVisible(true));
        $this->assertSame($zen, $zen->setMessage('message'));
        $this->assertSame($zen, $zen->setTooltip('tooltip'));

        $this->assertEquals('icon:icon' . PHP_EOL . 'visible:true' . PHP_EOL . 'message:message' . PHP_EOL . 'tooltip:tooltip' . PHP_EOL, $this->stdin);
    }
}
