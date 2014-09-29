<?php

use Clue\React\Zenity\Dialog\CalendarDialog;

class CalendarDialogTest extends AbstractDialogTest
{
    protected function createDialog()
    {
        return new CalendarDialog();
    }

    protected function getType()
    {
        return '--calendar';
    }

    protected function getFixedArgs()
    {
        return array('--date-format=%Y-%m-%d');
    }

    public function testDateIndividual()
    {
        $dialog = new CalendarDialog();

        $this->assertSame($dialog, $dialog->setText('text'));
        $this->assertSame($dialog, $dialog->setYear(2014));
        $this->assertSame($dialog, $dialog->setMonth(8));
        $this->assertSame($dialog, $dialog->setDay(2));

        $this->assertDialogArgs(array('--text=text', '--year=2014', '--month=8', '--day=2'), $dialog);
    }

    public function testDateFromDateTime()
    {
        $dialog = new CalendarDialog();

        $this->assertSame($dialog, $dialog->setDateTime(new DateTime('2014-08-02')));

        $this->assertDialogArgs(array('--year=2014', '--month=8', '--day=2'), $dialog);
    }
}
