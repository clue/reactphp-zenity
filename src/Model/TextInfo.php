<?php

namespace Clue\Zenity\React\Model;

use Clue\Zenity\React\Zenity;

class TextInfo extends Zenity
{
    protected $filename;

    protected $editable = false;

    protected $checkbox;

    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    public function setEditable($editable)
    {
        $this->editable = !!$editable;

        return $this;
    }

    public function setCheckbox($checkbox)
    {
        $this->checkbox = $checkbox;

        return $this;
    }

    public function setText($text)
    {
        $this->writeln($text);

        return $this;
    }

    public function writeLine($line)
    {
        $this->writeln($line);

        return $this;
    }
}
