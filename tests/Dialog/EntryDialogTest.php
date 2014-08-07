<?php

use Clue\React\Zenity\Dialog\EntryDialog;

class EntryDialogTest extends AbstractDialogTest
{
    protected function createDialog()
    {
        return new EntryDialog();
    }

    protected function getType()
    {
        return '--entry';
    }

    public function testArgs()
    {
        $dialog = new EntryDialog();

        $this->assertSame($dialog, $dialog->setText('text'));
        $this->assertSame($dialog, $dialog->setEntryText('prefill'));
        $this->assertSame($dialog, $dialog->setHideText(true));

        $this->assertDialogArgs(array('--text=text', '--entry-text=prefill', '--hide-text'), $dialog);
    }

    public function testShowPalette()
    {
        $dialog = new EntryDialog();

        $this->assertSame($dialog, $dialog->setHideText(true)->setHideText(false));

        $this->assertDialogArgs(array(), $dialog);
    }

    public function testParsingValues()
    {
        $this->assertParsingValues(array(
            'test' => 'test',
            '  with  white  space  ' => '  with  white  space  '
        ));
    }
}
