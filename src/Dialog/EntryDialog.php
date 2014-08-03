<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractTextDialog;

class EntryDialog extends AbstractTextDialog
{
    protected $entryText;
    protected $hideText = false;

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
