<?php

namespace Clue\Zenity\React\Model;

use Clue\Zenity\React\Zenity;

class Warning extends Zenity
{
    protected $text;

    public function setText($text)
    {
        $this->text = $text;
    }
}
