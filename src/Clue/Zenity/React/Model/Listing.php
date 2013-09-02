<?php

namespace Clue\Zenity\React\Model;

use Clue\Zenity\React\Zenity;

/**
 *
 *
 * The name 'list' is a reserved keyword in PHP, hence the name 'listing'.
 */
class Listing extends Zenity
{
    protected $text;
    protected $checklist = false;
    protected $radiolist = false;
    protected $imagelist = false;

    // no setters:
    protected $columns = array();
    protected $separator = '|||';

    protected $multiple = false;
    protected $editable = false;
    protected $printColumn;
    protected $hideHeader = false;

    public function addColumn($column, $hide = false)
    {
        $this->columns[] = '--column=' . $column;

        if ($hide) {
            // this will break
            $this->columns[] = '--hide-column=' . count($this->columns);
        }
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setChecklist($check)
    {
        $this->checklist = !!$check;
    }

    public function setRadiolist($radio)
    {
        $this->radiolist = !!$radio;
    }

    public function setImagelist($image)
    {
        $this->imagelist = !!$image;
    }

    public function setMultiple($multiple)
    {
        $this->multiple = !!$multiple;
    }

    public function setEditable($editable)
    {
        $this->editable = !!$editable;
    }

    public function setPrintColumn($column)
    {
        $this->printColumn = $column;
    }

    public function setHideHeader($hide)
    {
        $this->hideHeader = !!$hide;
    }

    public function writeLine($line)
    {
        $this->writeln($line);
    }

    public function getArgs()
    {
        return array_merge(parent::getArgs(), $this->columns);
    }

    public function getType()
    {
        return 'list';
    }

    protected function parseValue($value)
    {
        if (trim($value) === '') {
            // TODO: move logic
            return false;
        }
        if ($this->multiple || $this->checklist) {
            $value = explode($this->separator, $value);
        }
        return $value;
    }
}
