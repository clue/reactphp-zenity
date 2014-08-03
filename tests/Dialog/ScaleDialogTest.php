<?php

use Clue\React\Zenity\Dialog\ScaleDialog;
class ScaleDialogTest extends TestCase
{
    public function testEmptyDialog()
    {
        $dialog = new ScaleDialog();

        $this->assertEquals(array('--scale'), $dialog->getArgs());
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
