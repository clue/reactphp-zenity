<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;
use Clue\React\Zenity\Zen\ColorSelectionZen;

/**
 * Use the --color-selection option to create a color selection dialog.
 *
 * @link https://help.gnome.org/users/zenity/stable/color-selection.html
 */
class ColorSelectionDialog extends AbstractDialog
{
    protected $color;
    protected $showPalette = false;

    /**
     * Set the initial color.(ex: #FF0000)
     *
     * @param string $color
     * @return self chainable
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Show the palette.
     *
     * @param boolean $palette
     * @return self chainable
     */
    public function setShowPalette($palette)
    {
        $this->showPalette = !!$palette;

        return $this;
    }

    public function createZen()
    {
        return new ColorSelectionZen();
    }
}
