<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;
use Clue\React\Zenity\Zen\TextInfoZen;
use React\Promise\Deferred;
use Icecave\Mephisto\Process\ProcessInterface;

/**
 * Use the --text-info option to create a text information dialog.
 *
 * If the `setEditable(true)` flag is used, the edited text will be reported
 * back when the dialog is closed. Otherwise, this dialog reports a boolean
 * 'true' value.
 *
 * @link https://help.gnome.org/users/zenity/stable/text.html
 */
class TextInfoDialog extends AbstractDialog
{
    protected $filename;

    protected $editable = false;

    protected $checkbox;

    /**
     * Specifies a file that is loaded in the text information dialog.
     *
     * @param string $filename
     * @return self chainable
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Allows the displayed text to be edited.
     *
     * The edited text is returned to standard output when the dialog is closed.
     *
     * @param boolean $editable
     * @return self chainable
     */
    public function setEditable($editable)
    {
        $this->editable = !!$editable;

        return $this;
    }

    /**
     * Enable a checkbox for use like a 'I read and accept the terms.'
     *
     * @param string $checkbox
     * @return self chainable
     */
    public function setCheckbox($checkbox)
    {
        $this->checkbox = $checkbox;

        return $this;
    }

    /**
     * Writes a single line to the buffer.
     *
     * The lines will be passed to the zenity instance when the dialog is
     * launched.
     *
     * @param string $line
     * @return self chainable
     */
    public function addLine($line)
    {
        $this->writeln($line);

        return $this;
    }

    public function createZen(Deferred $deferred, ProcessInterface $process)
    {
        return new TextInfoZen($deferred, $process);
    }
}
