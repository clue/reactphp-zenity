<?php

use Clue\React\Zenity\Dialog\WarningDialog;

class WarningDialogTest extends AbstractMessageDialogTest
{
    protected function createDialog()
    {
        return new WarningDialog();
    }

    protected function getType()
    {
        return '--warning';
    }
}
