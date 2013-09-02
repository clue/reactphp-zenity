<?php

namespace Clue\Zenity\React\Model;

use Clue\Zenity\React\Zenity;

class Calendar extends Zenity
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
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function setMonth($month)
    {
        $this->month = $month;
    }

    public function setDay($day)
    {
        $this->day = $day;
    }

    public function setDateTime(\DateTime $date)
    {
        $this->setYear($date->format('Y'));
        $this->setMonth($date->format('m'));
        $this->setDay($date->format('d'));
    }

    protected function parseValue($value)
    {
        return new \DateTime($value);
    }
}
