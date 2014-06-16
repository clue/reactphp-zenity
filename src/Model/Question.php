<?php

namespace Clue\React\Zenity\Model;

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
