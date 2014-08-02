<?php

namespace Clue\React\Zenity\Builder;

use Clue\React\Zenity\Dialog\ProgressDialog;

class ProgressBuilder
{
    public function progress($text = null)
    {
        $zenity = new ProgressDialog();
        $zenity->setText($text);
        $zenity->setAutoClose(true);

        return $zenity;
    }

    public function pulsate($text = null)
    {
        $zenity = new ProgressDialog();
        $zenity->setText($text);
        $zenity->setPulsate(true);
        $zenity->setAutoClose(true);

        return $zenity;
    }
}
