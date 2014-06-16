<?php

namespace Clue\Zenity\React\Model;

use Clue\Zenity\React\Zenity;

class Question extends Zenity
{
    protected $text;

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }
}
