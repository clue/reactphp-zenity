<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractTextDialog;

/**
 * Use the --entry option to create a text entry dialog.
 *
 * The contents of the text entry will be reported back as a string.
 *
 * @link https://help.gnome.org/users/zenity/stable/entry.html
 */
class EntryDialog extends AbstractTextDialog
{
    protected $entryText;
    protected $hideText = false;

    /**
     * Specifies the text that is displayed in the entry field of the text entry dialog.
     *
     * @param string $text
     * @return self chainable
     */
    public function setEntryText($text)
    {
        $this->entryText = $text;

        return $this;
    }

    /**
     * Hides the text in the entry field of the text entry dialog.
     *
     * Useful when asking for confidential information (passwords etc.).
     * Consider using PasswordDialog instead.
     *
     * @param boolean $toggle
     * @return self chainable
     * @see PasswordDialog
     */
    public function setHideText($toggle)
    {
        $this->hideText = !!$toggle;

        return $this;
    }
}
