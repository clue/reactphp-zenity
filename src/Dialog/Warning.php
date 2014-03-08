<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;

class Warning extends AbstractDialog
{
    protected $text;

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }
}
