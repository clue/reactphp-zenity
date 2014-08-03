<?php

abstract class AbstractMessageDialogTest extends AbstractDialogTest
{
    public function testTextArg()
    {
        $dialog = $this->createDialog();
        $dialog->setText('test');

        $this->assertDialogArgs(array('--text=test'), $dialog);
    }
}
