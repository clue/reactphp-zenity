<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractTextDialog;
use Clue\React\Zenity\Zen\ScaleZen;

/**
 * Use the --scale option to create a scale dialog.
 *
 * The default dialog text is "Adjust the scale value" (depending on locale).
 *
 * @link https://help.gnome.org/users/zenity/stable/scale.html
 */
class ScaleDialog extends AbstractTextDialog
{
    protected $value;
    protected $minValue;
    protected $maxValue;
    protected $step;

    // protected $printPartial = false;

    protected $hideValue = false;

    /**
     * Set initial value. (Default: 0) You must specify value between minimum value to maximum value.
     *
     * @param int $value
     * @return self chainable
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Set minimum value. (Default: 0)
     *
     * @param int $value
     * @return self chainable
     */
    public function setMinValue($value)
    {
        $this->minValue = $value;

        return $this;
    }

    /**
     * Set maximum value. (Default: 100)
     *
     * @param int $value
     * @return self chainable
     */
    public function setMaxValue($value)
    {
        $this->maxValue = $value;

        return $this;
    }

    /**
     * Set step size. (Default: 1)
     *
     * @param int $value
     * @return self chainable
     */
    public function setStep($value)
    {
        $this->step = $value;

        return $this;
    }

    /**
     * Hide value on dialog.
     *
     * @param boolean $toggle
     * @return self chainable
     */
    public function setHideValue($toggle = true)
    {
        $this->hideValue = !!$toggle;

        return $this;
    }

    public function createZen()
    {
        return new ScaleZen();
    }
}
