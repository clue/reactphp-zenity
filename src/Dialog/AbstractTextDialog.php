<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;

/**
 * Abstract base class for all dialogs that support passing a text.
 *
 * For each type, use the --text option to specify the text that is displayed in the dialog.
 * The text is commonly printed as the main (or first) information in the dialog.
 *
 * Also inherits all properties and options from common AbstractDialog base.
 *
 * @see AbstractDialog
 */
abstract class AbstractTextDialog extends AbstractDialog
{
    protected $text;

    /**
     * Construct new text dialog
     *
     * Passing a $text is optional. Most dialog types define a default text
     * as a fallback. Some dialog types leave out the text if non is passed.
     *
     * @param string|null $text (optional) main text displayed in the dialog.
     */
    public function __construct($text = null)
    {
        $this->text = $text;
    }

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
