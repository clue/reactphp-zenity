<?php

abstract class AbstractMessageDialogTest extends AbstractDialogTest
{
    public function testEmpty()
    {
        $dialog = $this->createDialog();

        $this->assertEquals(array($this->getType()), $dialog->getArgs());
    }

    public function testArgs()
    {
        $dialog = $this->createDialog();
        $dialog->setText('test');

        $this->assertEquals(array($this->getType(), 'text' => 'test'), $dialog->getArgs());
    }
}
