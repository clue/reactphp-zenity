<?php

use Clue\React\Zenity\Dialog\NotificationDialog;

class NotificationDialogTest extends AbstractDialogTest
{
    protected function createDialog()
    {
        return new NotificationDialog();
    }

    protected function getType()
    {
        return '--notification';
    }

    public function testListeningNotification()
    {
        $dialog = new NotificationDialog();
        $this->assertSame($dialog, $dialog->setText('text'));
        $this->assertSame($dialog, $dialog->setListen(true));

        $this->assertDialogArgs(array('--text=text', '--listen'), $dialog);
    }

    public function testUnsetBools()
    {
        $dialog = new NotificationDialog();
        $this->assertSame($dialog, $dialog->setListen(true)->setListen(false));

        $this->assertDialogArgs(array(), $dialog);
    }

    public function testZen()
    {
        $zen = $this->createZen();

        $this->assertInstanceOf('Clue\React\Zenity\Zen\NotificationZen', $zen);
    }
}
