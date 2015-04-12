<?php

namespace Clue\React\Zenity\Zen;

use Clue\React\Zenity\Zen\BaseZen;

class ProgressZen extends BaseZen
{
    private $percentage;

    public function __construct($percentage)
    {
        $this->percentage = $percentage;
    }

    /**
     * Specifies the text that is displayed in the progress dialog.
     *
     * @param string $text
     * @return self chainable
     */
    public function setText($text)
    {
        $this->writeln('#' . $text);

        return $this;
    }

    /**
     * Specifies the initial percentage that is set in the progress dialog.
     *
     * @param int $percentage
     * @return self chainable
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        $this->writeln($percentage);

        return $this;
    }

    /**
     * advance progress by $by percent
     *
     * @param int $by
     * @return self chainable
     */
    public function advance($by)
    {
        $this->setPercentage($this->percentage + $by);

        return $this;
    }

    /**
     * complete progress dialog by setting percentage to 100%
     *
     * @return self chainable
     */
    public function complete()
    {
        $this->setPercentage(100);

        return $this;
    }

    /**
     * get current percentage
     *
     * @return int
     */
    public function getPercentage()
    {
        return $this->percentage;
    }
}
