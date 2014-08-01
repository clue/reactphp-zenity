<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;

class CalendarDialog extends AbstractDialog
{
    protected $text;
    protected $year;
    protected $month;
    protected $day;

    // no setter:
    protected $dateFormat = '%Y-%m-%d';

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    public function setDateTime(\DateTime $date)
    {
        $this->setYear($date->format('Y'));
        $this->setMonth($date->format('m'));
        $this->setDay($date->format('d'));

        return $this;
    }

    public function parseValue($value)
    {
        return new \DateTime($value);
    }
}
