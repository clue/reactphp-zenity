<?php

use Clue\React\Zenity\Dialog\PasswordDialog;

class PasswordDialogTest extends AbstractDialogTest
{
    protected function createDialog()
    {
        return new PasswordDialog();
    }

    protected function getType()
    {
        return '--password';
    }

    public function testArgs()
    {
        $dialog = new PasswordDialog();
        $this->assertSame($dialog, $dialog->setUsername(true));

        $this->assertDialogArgs(array('--username'), $dialog);
    }

    public function testUnsetUsername()
    {
        $dialog = new PasswordDialog();
        $this->assertSame($dialog, $dialog->setUsername(true)->setUsername(false));

        $this->assertDialogArgs(array(), $dialog);
    }

    public function testParsingValues()
    {
        $this->assertParsingValues(array(
            'username' => 'username',
            'user|name!"§$%'   => 'user|name!"§$%'
        ));
    }

    public function testParsingUsernamePassword()
    {
        $dialog = new PasswordDialog();
        $dialog->setUsername(true);

        $this->assertEquals(array('username', 'password'), $dialog->parseValue('username|password'));
        $this->assertEquals(array('user', 'name|pass|word'), $dialog->parseValue('user|name|pass|word'));
    }
}
