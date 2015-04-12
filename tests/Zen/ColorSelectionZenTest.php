<?php

use Clue\React\Zenity\Zen\ColorSelectionZen;

class ColorSelectionZenTest extends BaseZenTest
{
    public function testParsingValues()
    {
        $zen = new ColorSelectionZen();

        $this->assertEquals('#123456', $zen->parseValue('#121234345656'));
    }
}
