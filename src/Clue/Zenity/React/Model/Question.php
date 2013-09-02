<?php

namespace Clue\Zenity\React\Model;

use Clue\Zenity\React\Zenity;

class Question extends Zenity
{
    protected $okLabel = null;
    protected $cancelLabel = null;

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setOkLabel($label)
    {
        $this->okLabel = $label;
    }

    public function setCancelLabel($label)
    {
        $this->cancelLabel = $label;
    }
}
