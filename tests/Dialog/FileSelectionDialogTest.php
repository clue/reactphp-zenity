<?php

use Clue\React\Zenity\Dialog\FileSelectionDialog;

class FileSelectionDialogTest extends AbstractDialogTest
{
    protected function createDialog()
    {
        return new FileSelectionDialog();
    }

    protected function getType()
    {
        return '--file-selection';
    }

    protected function getFixedArgs()
    {
        return array(
            '--separator=|||'
        );
    }

    public function testSelectMultipleDirectories()
    {
        $dialog = new FileSelectionDialog();

        $this->assertSame($dialog, $dialog->setFilename(__DIR__));
        $this->assertSame($dialog, $dialog->setMultiple(true));
        $this->assertSame($dialog, $dialog->setDirectory(true));

        $this->assertDialogArgs(array('--filename=' . __DIR__, '--multiple', '--directory'), $dialog);
    }

    public function testSelectMarkdownForOverwritingSave()
    {
        $dialog = new FileSelectionDialog();

        $this->assertSame($dialog, $dialog->setSave(true));
        $this->assertSame($dialog, $dialog->setConfirmOverwrite(true));
        $this->assertSame($dialog, $dialog->setFileFilter('*.md'));

        $this->assertDialogArgs(array('--save', '--confirm-overwrite', '--file-filter=*.md'), $dialog);
    }


    public function testUnsetBools()
    {
        $dialog = new FileSelectionDialog();

        $this->assertSame($dialog, $dialog->setMultiple(true)->setMultiple(false));
        $this->assertSame($dialog, $dialog->setDirectory(true)->setDirectory(false));
        $this->assertSame($dialog, $dialog->setSave(true)->setSave(false));
        $this->assertSame($dialog, $dialog->setConfirmOverwrite(true)->setConfirmOverwrite(false));

        $this->assertDialogArgs(array(), $dialog);
    }

    public function testParsingSingleValues()
    {
        $this->assertParsingValues(array(
            'test' => new SplFileInfo('test')
        ));
    }

    public function testParsingMultipleValues()
    {
        $dialog = new FileSelectionDialog();
        $dialog->setMultiple(true);

        $selection = 'README.md|||CHANGELOG.md';
        $expected = array(
            new SplFileInfo('README.md'),
            new SplFileInfo('CHANGELOG.md')
        );

        $this->assertEquals($expected, $dialog->parseValue($selection));
    }

    public function testParsingSingleValueInMultipleSelection()
    {
        $dialog = new FileSelectionDialog();
        $dialog->setMultiple(true);

        $selection = 'README.md';
        $expected = array(
            new SplFileInfo('README.md')
        );

        $this->assertEquals($expected, $dialog->parseValue($selection));
    }
}
