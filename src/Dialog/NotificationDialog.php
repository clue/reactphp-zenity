<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractTextDialog;

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

    /**
     * Sends "icon" command.
     *
     * @param string $icon
     * @return self chainable
     */
    public function setIcon($icon)
    {
        $this->writeln('icon:' . $icon);

        return $this;
    }

    /**
     * Sends "visible" command.
     *
     * @param boolean $visible
     * @return self chainable
     */
    public function setVisible($visible)
    {
        $this->writeln('visible:' . ($visible ? 'true' : 'false'));

        return $this;
    }

    /**
     * Sends "message" command.
     *
     * @param string $message
     * @return self chainable
     */
    public function setMessage($message)
    {
        $this->writeln('message:' . $message);

        return $this;
    }

    /**
     * Sends "tooltip" command.
     *
     * @param string $tooltip
     * @return self chainable
     */
    public function setTooltip($tooltip)
    {
        $this->writeln('tooltip:' . $tooltip);

        return $this;
    }
}
