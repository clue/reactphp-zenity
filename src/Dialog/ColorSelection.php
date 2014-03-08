<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;

class ColorSelection extends AbstractDialog
{
    protected $color;
    protected $showPalette = false;

    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    public function setShowPalette($palette)
    {
        $this->showPalette = !!$palette;

        return $this;
    }

    public function parseValue($value)
    {
        // https://answers.launchpad.net/ubuntu/+source/zenity/+question/204096

        $value = '#' . substr($value, 1, 2) . substr($value, 5, 2) . substr($value, 9, 2);

        return $value;
    }
}
