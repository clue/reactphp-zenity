<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Zenity;

class Question extends Zenity
{
    protected $text;

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }
}
