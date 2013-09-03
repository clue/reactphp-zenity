<?php

namespace Clue\Zenity\React\Model;

use Clue\Zenity\React\Zenity;

class Info extends Zenity
{
    protected $text;

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }
}
