<?php

namespace Clue\Zenity\React\Model;

use Clue\Zenity\React\Zenity;

class Progress extends Zenity
{
    protected $text;
    protected $percentage;
    protected $autoClose = false;

    //protected $autoKill = false;

    protected $pulsate = false;
    protected $noCancel = false;

    public function setText($text)
    {
        $this->text = $text;

        $this->writeln('#' . $text);
    }

    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        $this->writeln($percentage);
    }

    public function setAutoClose($auto)
    {
        $this->autoClose = !!$auto;
    }

    public function setPulsate($pulsate)
    {
        $this->pulsate = !!$pulsate;
    }

    public function setNoCancel($noc)
    {
        $this->noCancel = !!$noc;
    }

    public function advance($by)
    {
        $this->setPercentage($this->percentage + $by);
    }

    public function complete()
    {
        $this->setPercentage(100);
    }

    public function getPercentage()
    {
        return $this->percentage;
    }
}
