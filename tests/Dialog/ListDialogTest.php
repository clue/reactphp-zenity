<?php

use Clue\React\Zenity\Dialog\ListDialog;

class ListDialogTest extends AbstractDialogTest
{
    protected function createDialog()
    {
        return new ListDialog();
    }

    protected function getType()
    {
        return '--list';
    }

    protected function getFixedArgs()
    {
        return array(
            '--separator=|||'
        );
    }

    public function testList()
    {
        $dialog = new ListDialog();

        $this->assertSame($dialog, $dialog->setText('text'));
        $this->assertSame($dialog, $dialog->addColumn('Id', true));
        $this->assertSame($dialog, $dialog->addColumn('Name'));
        $this->assertSame($dialog, $dialog->setPrintColumn(2));

        $this->assertSame($dialog, $dialog->writeLine('1'));
        $this->assertSame($dialog, $dialog->writeLine('name'));

        $this->assertDialogArgs(array('--text=text', '--print-column=2', '--column=Id', '--hide-column=1', '--column=Name'), $dialog);
        $this->assertEquals('1' . PHP_EOL . 'name' . PHP_EOL, $dialog->getInBuffer());
    }

    public function testSettingBools()
    {
        $dialog = new ListDialog();

        $this->assertSame($dialog, $dialog->setChecklist(true));
        $this->assertSame($dialog, $dialog->setRadiolist(true));
        $this->assertSame($dialog, $dialog->setImagelist(true));
        $this->assertSame($dialog, $dialog->setMultiple(true));
        $this->assertSame($dialog, $dialog->setEditable(true));
        $this->assertSame($dialog, $dialog->setHideHeader(true));

        $this->assertDialogArgs(
            array(
                '--checklist',
                '--radiolist',
                '--imagelist',
                '--multiple',
                '--editable',
                '--hide-header',
            ),
            $dialog
        );
    }

    public function testUnsettingBools()
    {
        $dialog = new ListDialog();

        $this->assertSame($dialog, $dialog->setChecklist(true)->setChecklist(false));
        $this->assertSame($dialog, $dialog->setRadiolist(true)->setRadiolist(false));
        $this->assertSame($dialog, $dialog->setImagelist(true)->setImagelist(false));
        $this->assertSame($dialog, $dialog->setMultiple(true)->setMultiple(false));
        $this->assertSame($dialog, $dialog->setEditable(true)->setEditable(false));
        $this->assertSame($dialog, $dialog->setHideHeader(true)->setHideHeader(false));

        $this->assertDialogArgs(array(), $dialog);
    }

    public function testParsingSingleValue()
    {
        $dialog = new ListDialog();

        $this->assertEquals('Nobody', $this->createZen($dialog)->parseValue('Nobody'));
    }

    public function testParsingSingleValueWithBuggedZenity()
    {
        $dialog = new ListDialog();

        $this->assertEquals('Nobody', $this->createZen($dialog)->parseValue('Nobody|||nobody@example.com|||20'));
    }

    public function testParsingMultipleValues()
    {
        $dialog = new ListDialog();
        $dialog->setMultiple(true);

        $this->assertEquals(array('Nobody', 'Somebody'), $this->createZen($dialog)->parseValue('Nobody|||Somebody'));
    }

    public function testParsingNoValue()
    {
        $dialog = new ListDialog();

        $this->assertEquals(false, $this->createZen($dialog)->parseValue(''));
    }
}
