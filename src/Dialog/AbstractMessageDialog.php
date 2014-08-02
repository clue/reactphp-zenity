<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;

/**
 * Abstract base for message dialogs: Error, Info, Question, Warning
 *
 * For each type, use the --text option to specify the text that is displayed in the dialog.
 *
 * @link https://help.gnome.org/users/zenity/stable/message.html
 */
abstract class AbstractMessageDialog extends AbstractDialog
{
    protected $text;

    /**
     * Specifies the text that is displayed in the dialog.
     *
     * @param string $text
     * @return self chainable
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }
}
