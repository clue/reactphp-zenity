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

        return $this;
    }

    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        $this->writeln($percentage);

        return $this;
    }

    public function setAutoClose($auto)
    {
        $this->autoClose = !!$auto;

        return $this;
    }

    public function setPulsate($pulsate)
    {
        $this->pulsate = !!$pulsate;

        return $this;
    }

    public function setNoCancel($noc)
    {
        $this->noCancel = !!$noc;

        return $this;
    }

    public function advance($by)
    {
        $this->setPercentage($this->percentage + $by);

        return $this;
    }

    public function complete()
    {
        $this->setPercentage(100);

        return $this;
    }

    public function getPercentage()
    {
        return $this->percentage;
    }
}
