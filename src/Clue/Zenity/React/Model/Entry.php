<?php

namespace Clue\Zenity\React\Model;

use Clue\Zenity\React\Zenity;

class Entry extends Zenity
{
    protected $text;
    protected $entryText;
    protected $hideText = false;

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setEntryText($text)
    {
        $this->entryText = $text;
    }

    public function setHideText($toggle)
    {
        $this->hideText = !!$toggle;
    }
}
