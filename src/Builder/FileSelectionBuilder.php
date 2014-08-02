<?php

namespace Clue\React\Zenity\Builder;

use Clue\React\Zenity\Dialog\FileSelectionDialog;

class FileSelectionBuilder
{
    public function fileSelection($title = null, $multiple = false)
    {
        $zenity = new FileSelectionDialog();
        $zenity->setTitle('Select any file');
        $zenity->setMultiple($multiple);

        return $zenity;
    }

    public function fileSave($title, $previous = null)
    {
        $zenity = new FileSelectionDialog();
        $zenity->setTitle($title);
        $zenity->setFilename($previous);
        $zenity->setSave(true);
        $zenity->setConfirmOverwrite(true);

        return $zenity;
    }

    public function directorySelection($title = null, $multiple = false)
    {
        $zenity = new FileSelectionDialog();
        $zenity->setDirectory(true);
        $zenity->setTitle($title);
        $zenity->setMultiple($multiple);

        return $zenity;
    }
}
