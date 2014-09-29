<?php

namespace Clue\React\Zenity\Zen;

use Clue\React\Zenity\Zen\BaseZen;

class ColorSelectionZen extends BaseZen
{
    /**
     * Parses the color string returned from the dialog into a #rrggbb string
     *
     * @internal
     * @see parent::parseValue()
     * @return string
     * @link https://answers.launchpad.net/ubuntu/+source/zenity/+question/204096
     */
    public function parseValue($value)
    {
        // convert zenity's #rrrrggggbbbb to #rrggbb by skipping duplicate info
        return '#' . substr($value, 1, 2) . substr($value, 5, 2) . substr($value, 9, 2);
    }
}
