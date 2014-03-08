<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;

class Notification extends AbstractDialog
{
    protected $text;
    protected $listen = false;

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function setListen($listen)
    {
        $this->listen = !!$listen;

        return $this;
    }

    public function setIcon($icon)
    {
        $this->writeln('icon:' . $icon);

        return $this;
    }

    public function setVisible($visible)
    {
        $this->writeln('visible:' . ($visible ? 'true' : 'false'));

        return $this;
    }

    public function setMessage($message)
    {
        $this->writeln('message:' . $message);

        return $this;
    }

    public function setTooltip($tooltip)
    {
        $this->writeln('tooltip:' . $tooltip);

        return $this;
    }
}
