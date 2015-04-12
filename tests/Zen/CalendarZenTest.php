<?php

use Clue\React\Zenity\Zen\CalendarZen;

class CalendarZenTest extends BaseZenTest
{
    public function testParsingValues()
    {
        $zen = new CalendarZen();

        $this->assertEquals(new DateTime('2014-08-02'), $zen->parseValue('2014-08-02'));
    }
}
