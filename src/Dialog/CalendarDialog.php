<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractTextDialog;
use DateTime;
use React\Promise\Deferred;
use Icecave\Mephisto\Process\ProcessInterface;
use Clue\React\Zenity\Zen\CalendarZen;

/**
 * Use the --calendar option to create a calendar dialog.
 *
 * Zenity returns the selected date. If no date is specified via the following
 * options, the dialog uses the current date.
 *
 * @link https://help.gnome.org/users/zenity/stable/calendar.html
 */
class CalendarDialog extends AbstractTextDialog
{
    protected $year;
    protected $month;
    protected $day;

    // no setter:
    protected $dateFormat = '%Y-%m-%d';

    /**
     * Specifies the year that is selected in the calendar dialog.
     *
     * @param int $year
     * @return self chainable
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Specifies the month that is selected in the calendar dialog.
     *
     * month must be a number between 1 and 12 inclusive.
     *
     * @param int $month
     * @return self chainable
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Specifies the day that is selected in the calendar dialog.
     *
     * day must be a number between 1 and 31 inclusive.
     *
     * @param int $day
     * @return self chainable
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Helper to set the year/month/day from the given DateTime instance
     *
     * @param DateTime $date
     * @return self chainable
     * @uses self::setYear()
     * @uses self::setMonth()
     * @uses self::setDay()
     */
    public function setDateTime(DateTime $date)
    {
        $this->setYear((int)$date->format('Y'));
        $this->setMonth((int)$date->format('m'));
        $this->setDay((int)$date->format('d'));

        return $this;
    }

    public function createZen(Deferred $deferred, ProcessInterface $process)
    {
        return new CalendarZen($deferred, $process);
    }
}
