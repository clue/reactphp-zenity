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

    public function testZen()
    {
        $dialog = new ProgressDialog();
        $dialog->setPercentage(50);

        $process = $this->getMockBuilder('React\ChildProcess\Process')->disableOriginalConstructor()->getMock();
        // TODO: assert writeline 50

        $zen = $dialog->createZen();

        $this->assertInstanceOf('Clue\React\Zenity\Zen\ProgressZen', $zen);
    }
}
