<?php

namespace Clue\React\Zenity\Zen;

class NotificationZen extends BaseZen
{
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
