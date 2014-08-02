<?php

namespace Clue\React\Zenity\Builder;

use Clue\React\Zenity\Dialog\TextInfoDialog;

class TextInfoBuilder
{
    public function text($filename, $title = null)
    {
        $zenity = new TextInfoDialog();
        $zenity->setFilename($filename);
        $zenity->setTitle($title);

        return $zenity;
    }

    public function editable($filename, $title = null)
    {
        $zenity = new TextInfoDialog();
        $zenity->setFilename($filename);
        $zenity->setTitle($title);
        $zenity->setEditable(true);

        return $zenity;
    }

    public function confirmLicense($filename, $confirmation, $title = null)
    {
        $zenity = new TextInfoDialog();
        $zenity->setFilename($filename);
        $zenity->setCheckbox($confirmation);
        $zenity->setTitle($title);

        return $zenity;
    }
}
