<?php

use Clue\React\Zenity\Dialog\ColorSelectionDialog;

class ColorSelectionDialogTest extends AbstractDialogTest
{
    protected function createDialog()
    {
        return new ColorSelectionDialog();
    }

    protected function getType()
    {
        return '--color-selection';
    }

    public function testArgs()
    {
        $dialog = new ColorSelectionDialog();

        $this->assertSame($dialog, $dialog->setColor('#123456'));
        $this->assertSame($dialog, $dialog->setShowPalette(true));

        $this->assertDialogArgs(array('--color=#123456', '--show-palette'), $dialog);
    }

    public function testShowPalette()
    {
        $dialog = new ColorSelectionDialog();

        $this->assertSame($dialog, $dialog->setShowPalette(true)->setShowPalette(false));

        $this->assertDialogArgs(array(), $dialog);
    }

    public function testParsingValues()
    {
        $this->assertParsingValues(array(
            '#121234345656' => '#123456'
        ));
    }
}
