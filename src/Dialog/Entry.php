<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;

class Entry extends AbstractDialog
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
