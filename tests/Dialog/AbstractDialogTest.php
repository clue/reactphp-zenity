<?php

use Clue\React\Zenity\Dialog\AbstractDialog;

abstract class AbstractDialogTest extends TestCase
{
    /**
     * @return AbstractDialog
     */
    abstract protected function createDialog();

    abstract protected function getType();

    public function testEmptyDialog()
    {
        $dialog = $this->createDialog();

        $this->assertEquals(array($this->getType()), $dialog->getArgs());
    }

    public function testDefaultArgs()
    {
        $dialog = $this->createDialog();

        $this->assertSame($dialog, $dialog->setTitle('title'));
        $this->assertSame($dialog, $dialog->setWindowIcon('icon'));
        $this->assertSame($dialog, $dialog->setTimeout(10));
        $this->assertSame($dialog, $dialog->setModal(true));
        $this->assertSame($dialog, $dialog->setWidth(200));
        $this->assertSame($dialog, $dialog->setHeight(100));
        $this->assertSame($dialog, $dialog->setOkLabel('Next'));
        $this->assertSame($dialog, $dialog->setCancelLabel('Previous'));

        $this->assertEquals(
            array(
                $this->getType(),
                'title' => 'title',
                'window-icon' => 'icon',
                'timeout' => 10,
                'modal' => true,
                'width' => 200,
                'height' => 100,
                'ok-label' => 'Next',
                'cancel-label' => 'Previous'
            ),
            $dialog->getArgs()
        );
    }
}
