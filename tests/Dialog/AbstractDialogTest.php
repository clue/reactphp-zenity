<?php

use Clue\React\Zenity\Dialog\AbstractDialog;

abstract class AbstractDialogTest extends TestCase
{
    /**
     * @return AbstractDialog
     */
    abstract protected function createDialog();

    protected function createZen(AbstractDialog $dialog = null)
    {
        $process = $this->getMockBuilder('React\ChildProcess\Process')->disableOriginalConstructor()->getMock();

        if ($dialog === null) {
            $dialog = $this->createDialog();
        }

        return $dialog->createZen($process);
    }

    abstract protected function getType();

    protected function getFixedArgs()
    {
        return array();
    }

    protected function assertDialogArgs(array $expected, AbstractDialog $dialog)
    {
        $all = array_merge($expected, array($this->getType()), $this->getFixedArgs());
        sort($all);

        $got = $dialog->getArgs();
        sort($got);

        $this->assertEquals(
            $all,
            $got
        );
    }

    public function testEmptyDialog()
    {
        $dialog = $this->createDialog();

        $this->assertDialogArgs(array(), $dialog);
    }

    public function testCreatesZen()
    {
        $this->assertInstanceOf('Clue\React\Zenity\Zen\BaseZen', $this->createZen());
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

        $this->assertDialogArgs(
            array(
                '--title=title',
                '--window-icon=icon',
                '--timeout=10',
                '--modal',
                '--width=200',
                '--height=100',
                '--ok-label=Next',
                '--cancel-label=Previous'
            ),
            $dialog
        );
    }

    public function assertParsingValues(array $values)
    {
        $zen = $this->createZen();

        foreach ($values as $in => $out) {
            $this->assertEquals($out, $zen->parseValue($in));
        }
    }
}
