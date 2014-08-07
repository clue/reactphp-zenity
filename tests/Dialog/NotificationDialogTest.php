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

    public function testCommands()
    {
        $dialog = new NotificationDialog();

        $this->assertSame($dialog, $dialog->setIcon('icon'));
        $this->assertSame($dialog, $dialog->setVisible(true));
        $this->assertSame($dialog, $dialog->setMessage('message'));
        $this->assertSame($dialog, $dialog->setTooltip('tooltip'));

        $this->assertEquals('icon:icon' . PHP_EOL . 'visible:true' . PHP_EOL . 'message:message' . PHP_EOL . 'tooltip:tooltip' . PHP_EOL, $dialog->getInBuffer());
    }
}
