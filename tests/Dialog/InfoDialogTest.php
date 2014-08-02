<?php

use Clue\React\Zenity\Dialog\InfoDialog;

class InfoDialogTest extends AbstractMessageDialogTest
{
    protected function createDialog()
    {
        return new InfoDialog();
    }

    protected function getType()
    {
        return '--info';
    }
}
