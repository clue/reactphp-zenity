<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;

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
