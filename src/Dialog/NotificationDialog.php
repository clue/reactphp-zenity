<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractTextDialog;
use Clue\React\Zenity\Zen\NotificationZen;
use React\Promise\Deferred;
use Icecave\Mephisto\Process\ProcessInterface;

/**
 * Use the --notification option to create a notification icon.
 *
 * @link https://help.gnome.org/users/zenity/stable/notification.html
 */
class NotificationDialog extends AbstractTextDialog
{
    protected $listen = false;

    /**
     * Listens for commands at standard input.
     *
     * At least one command must be specified. Commands are comma seperated.
     * A command must be followed by a colon and a value.
     *
     * @param unknown $listen
     * @return self chainable
     */
    public function setListen($listen)
    {
        $this->listen = !!$listen;

        return $this;
    }

    public function createZen(Deferred $deferred, ProcessInterface $process)
    {
        return new NotificationZen($deferred, $process);
    }
}
