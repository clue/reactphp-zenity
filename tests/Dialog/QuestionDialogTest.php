<?php

use Clue\React\Zenity\Dialog\QuestionDialog;

class QuestionDialogTest extends AbstractMessageDialogTest
{
    protected function createDialog()
    {
        return new QuestionDialog();
    }

    protected function getType()
    {
        return '--question';
    }
}
