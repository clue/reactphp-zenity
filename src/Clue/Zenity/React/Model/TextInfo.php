<?php

namespace Clue\Zenity\React\Model;

use Clue\Zenity\React\Zenity;

class TextInfo extends Zenity
{
    protected $filename;

    protected $editable = false;

    protected $checkbox;

    protected $okLabel;

    protected $cancelLabel;

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function setEditable($editable)
    {
        $this->editable = !!$editable;
    }

    public function setCheckbox($checkbox)
    {
        $this->checkbox = $checkbox;
    }

    public function setOkLabel($label)
    {
        $this->okLabel = $label;
    }

    public function setCancelLabel($label)
    {
        $this->cancelLabel = $label;
    }

    public function setText($text)
    {
        $this->writeln($text);
    }

    public function writeLine($line)
    {
        $this->writeln($line);
    }
}
