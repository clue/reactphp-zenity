<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Zenity;

class Entry extends Zenity
{
    protected $text;
    protected $entryText;
    protected $hideText = false;

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function setEntryText($text)
    {
        $this->entryText = $text;

        return $this;
    }

    public function setHideText($toggle)
    {
        $this->hideText = !!$toggle;

        return $this;
    }
}
