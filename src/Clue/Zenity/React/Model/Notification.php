<?php

namespace Clue\Zenity\React\Model;

use Clue\Zenity\React\Zenity;

class Notification extends Zenity
{
    protected $text;
    protected $listen = false;

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setListen($listen)
    {
        $this->listen = !!$listen;
    }

    public function setIcon($icon)
    {
        $this->writeln('icon:' . $icon);
    }

    public function setVisible($visible)
    {
        $this->writeln('visible:' . ($visible ? 'true' : 'false'));
    }

    public function setMessage($message)
    {
        $this->writeln('message:' . $message);
    }

    public function setTooltip($tooltip)
    {
        $this->writeln('tooltip:' . $tooltip);
    }
}
