<?php

namespace Clue\React\Zenity\Zen;

use Clue\React\Zenity\Zen\BaseZen;
use DateTime;

class CalendarZen extends BaseZen
{
    /**
     * Parses the date string returned from the dialog into a DateTime object
     *
     * @internal
     * @see parent::parseValue()
     * @return \DateTime
     */
    public function parseValue($value)
    {
        return new DateTime($value);
    }
}
