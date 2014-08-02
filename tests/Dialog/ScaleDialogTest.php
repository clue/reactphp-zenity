<?php

use Clue\React\Zenity\Dialog\ScaleDialog;

class ScaleDialogTest extends AbstractDialogTest
{
    protected function createDialog()
    {
        return new ScaleDialog();
    }

    protected function getType()
    {
        return '--scale';
    }

    public function testArgs()
    {
        $dialog = new ScaleDialog();
        $dialog->setText('test');
        $dialog->setValue(1500);
        $dialog->setMinValue(1000);
        $dialog->setMaxValue(2000);
        $dialog->setStep(10);
        $dialog->setHideValue();

        $this->assertEquals(array('--scale', 'text' => 'test', 'value' => 1500, 'min-value' => 1000, 'max-value' => 2000, 'step' => 10, 'hide-value' => true), $dialog->getArgs());
    }

    public function testHideValue()
    {
        $dialog = new ScaleDialog();
        $dialog->setHideValue(true);
        $dialog->setHideValue(false);

        $this->assertEquals(array('--scale'), $dialog->getArgs());
    }
}
