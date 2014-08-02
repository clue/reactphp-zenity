<?php

use Clue\React\Zenity\Dialog\ErrorDialog;

class ErrorDialogTest extends AbstractMessageDialogTest
{
    protected function createDialog()
    {
        return new ErrorDialog();
    }

    protected function getType()
    {
        return '--error';
    }
}
