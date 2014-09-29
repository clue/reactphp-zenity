<?php

namespace Clue\React\Zenity\Zen;

use Clue\React\Zenity\Zen\BaseZen;
use React\Promise\Deferred;
use Icecave\Mephisto\Process\ProcessInterface;

class FormsZen extends BaseZen
{
    private $separator;

    public function __construct(Deferred $deferred, ProcessInterface $process, $separator)
    {
        parent::__construct($deferred, $process);

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
