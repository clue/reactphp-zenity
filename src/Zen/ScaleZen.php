<?php

namespace Clue\React\Zenity\Zen;

use Clue\React\Zenity\Zen\BaseZen;

class ScaleZen extends BaseZen
{
    /**
     * Converts the scale string returned from the dialog to an integer
     *
     * @internal
     * @see parent::parseValue()
     * @return int
     */
    public function parseValue($value)
    {
        return (int)$value;
    }
}
