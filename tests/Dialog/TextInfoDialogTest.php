<?php

use Clue\React\Zenity\Dialog\TextInfoDialog;

class TextInfoDialogTest extends AbstractDialogTest
{
    protected function createDialog()
    {
        return new TextInfoDialog();
    }

    protected function getType()
    {
        return '--text-info';
    }

    public function testArgs()
    {
        $dialog = new TextInfoDialog();
        $this->assertSame($dialog, $dialog->setFilename('filename'));
        $this->assertSame($dialog, $dialog->setEditable(true));
        $this->assertSame($dialog, $dialog->setCheckbox('Confirmed'));

        $this->assertSame($dialog, $dialog->writeLine('hello'));
        $this->assertSame($dialog, $dialog->writeLine('world'));

        $this->assertDialogArgs(array('--filename=filename', '--editable', '--checkbox=Confirmed'), $dialog);
        $this->assertEquals('hello' . PHP_EOL . 'world' . PHP_EOL, $dialog->getInBuffer());
    }

    public function testUnsetEditable()
    {
        $dialog = new TextInfoDialog();
        $this->assertSame($dialog, $dialog->setEditable(true)->setEditable(false));

        $this->assertDialogArgs(array(), $dialog);
    }
}
