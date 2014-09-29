<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractTextDialog;
use Clue\React\Zenity\Zen\ProgressZen;
use React\Promise\Deferred;
use React\ChildProcess\Process;

/**
 *  Use the --progress option to create a progress dialog.
 *
 *  Zenity reads data from standard input line by line.
 *  If a line is prefixed with #, the text is updated with the text on that line.
 *  If a line contains only a number, the percentage is updated with that number.
 *
 * @link https://help.gnome.org/users/zenity/stable/progress.html
 */
class ProgressDialog extends AbstractTextDialog
{
    protected $percentage;
    protected $autoClose = false;

    //protected $autoKill = false;

    protected $pulsate = false;
    protected $noCancel = false;


    /**
     * Specifies the initial percentage that is set in the progress dialog.
     *
     * @param int $percentage
     * @return self chainable
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Closes the progress dialog when 100% has been reached.
     *
     * @param boolean $auto
     * @return self chainable
     */
    public function setAutoClose($auto)
    {
        $this->autoClose = !!$auto;

        return $this;
    }

    /**
     * Specifies that the progress bar pulsates until an EOF character is read from standard input.
     *
     * @param boolean $pulsate
     * @return self chainable
     */
    public function setPulsate($pulsate)
    {
        $this->pulsate = !!$pulsate;

        return $this;
    }

    /**
     * Hide cancel button.
     *
     * @param boolean $noc
     * @return self chainable
     */
    public function setNoCancel($noc)
    {
        $this->noCancel = !!$noc;

        return $this;
    }

    public function createZen(Deferred $deferred, Process $process)
    {
        return new ProgressZen($deferred, $process, $this->percentage);
    }
}
