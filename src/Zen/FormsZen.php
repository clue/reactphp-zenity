<?php

namespace Clue\React\Zenity\Zen;

use Clue\React\Zenity\Zen\BaseZen;

class FormsZen extends BaseZen
{
    private $separator;

    public function __construct($separator)
    {
        $this->separator = $separator;
    }

    /**
     * Parses the input string returned from the dialog into an array of string values
     *
     * @return string[]
     * @internal
     * @see parent::parseValue()
     */
    public function parseValue($value)
    {
        return explode($this->separator, $value);
    }
}
