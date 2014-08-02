<?php

use Clue\React\Zenity\Dialog\FormsDialog;

class FormsDialogTest extends AbstractDialogTest
{
    protected function createDialog()
    {
        return new FormsDialog();
    }

    protected function getType()
    {
        return '--forms';
    }

    protected function getFixedArgs()
    {
        return array(
            '--forms-date-format=%Y-%m-%d',
            '--separator=|||'
        );
    }

    public function testRegistrationForm()
    {
        $dialog = new FormsDialog();

        $this->assertSame($dialog, $dialog->setText('Register'));
        $this->assertSame($dialog, $dialog->addEntry('Name'));
        $this->assertSame($dialog, $dialog->addPassword('Password'));
        $this->assertSame($dialog, $dialog->addPassword('Confirmation'));

        $this->assertDialogArgs(
            array(
                '--text=Register',
                '--add-entry=Name',
                '--add-password=Password',
                '--add-password=Confirmation'
            ),
            $dialog
        );
    }

    public function testCalendarForm()
    {
        $dialog = new FormsDialog();

        $this->assertSame($dialog, $dialog->addEntry('Title'));
        $this->assertSame($dialog, $dialog->addCalendar('Date'));
        $this->assertSame($dialog, $dialog->addList('Priority', array('normal', 'high')));

        $this->assertDialogArgs(
            array(
                '--add-entry=Title',
                '--add-calendar=Date',
                '--add-list=Priority',
                '--list-values=normal|high'
            ),
            $dialog
        );
    }

    public function testTableFormWithHeaders()
    {
        $dialog = new FormsDialog();

        $this->assertSame($dialog, $dialog->addList('Target', array('nobody', '20'), array('Name', 'Age')));

        $this->assertDialogArgs(
            array(
                '--add-list=Target',
                '--list-values=nobody|20',
                '--show-header',
                '--column-values=Name|Age'
            ),
            $dialog
        );
    }

    public function testTableFormWithoutHeaders()
    {
        $dialog = new FormsDialog();

        $this->assertSame($dialog, $dialog->addList('Target', array('nobody', 'nobody@example.com'), array(0, 1), false));

        $this->assertDialogArgs(
            array(
                '--add-list=Target',
                '--list-values=nobody|nobody@example.com',
                '--column-values=0|1'
            ),
            $dialog
        );
    }

    public function testParsingFormValues()
    {
        $this->assertParsingValues(array(
            'title|||2014-08-02|||normal' => array('title', '2014-08-02', 'normal')
        ));
    }
}
