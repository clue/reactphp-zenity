<?php

use Clue\React\Zenity\Dialog\ProgressDialog;

class ProgressDialogTest extends AbstractDialogTest
{
    protected function createDialog()
    {
        return new ProgressDialog();
    }

    protected function getType()
    {
        return '--progress';
    }

    public function testProgressDialogOptions()
    {
        $dialog = new ProgressDialog();
        $this->assertSame($dialog, $dialog->setText('text'));
        $this->assertSame($dialog, $dialog->setPercentage(30));
        $this->assertSame($dialog, $dialog->setAutoClose(true));
        $this->assertSame($dialog, $dialog->setNoCancel(true));

        $this->assertDialogArgs(array('--text=text', '--percentage=30', '--auto-close', '--no-cancel'), $dialog);
    }

    public function testPulsating()
    {
        $dialog = new ProgressDialog();
        $this->assertSame($dialog, $dialog->setText('text'));
        $this->assertSame($dialog, $dialog->setPulsate(true));

        $this->assertDialogArgs(array('--text=text', '--pulsate'), $dialog);
    }

    public function testUnsetBools()
    {
        $dialog = new ProgressDialog();
        $this->assertSame($dialog, $dialog->setAutoClose(true)->setAutoClose(false));
        $this->assertSame($dialog, $dialog->setNoCancel(true)->setNoCancel(false));
        $this->assertSame($dialog, $dialog->setPulsate(true)->setPulsate(false));

        $this->assertDialogArgs(array(), $dialog);
    }

    public function testPercentage()
    {
        $dialog = new ProgressDialog();
        $this->assertEquals(0, $dialog->getPercentage());

        $this->assertSame($dialog, $dialog->setPercentage(20));
        $this->assertEquals(20, $dialog->getPercentage());

        $this->assertSame($dialog, $dialog->advance(30));
        $this->assertEquals(50, $dialog->getPercentage());

        $this->assertSame($dialog, $dialog->complete());
        $this->assertEquals(100, $dialog->getPercentage());
    }
}
