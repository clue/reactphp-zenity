<?php

namespace Clue\React\Zenity\Builder;

use Clue\React\Zenity\Dialog\NotificationDialog;

class NotificationBuilder
{
    public function notification($text)
    {
        $zenity = new NotificationDialog();
        $zenity->setText($text);

        return $zenity;
    }

    public function notifier()
    {
        $zenity = new NotificationDialog();
        $zenity->setListen(true);

        return $zenity;
    }
}
