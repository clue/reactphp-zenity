<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;

/**
 * Abstract base for message dialogs: Error, Info, Question, Warning
 *
 * For each type, use the --text option to specify the text that is displayed in the dialog.
 * The text is the main information presented to the user.
 *
 * Also inherits all properties and options from common AbstractMessageDialog
 * and AbstractDialog base classes.
 *
 * @link https://help.gnome.org/users/zenity/stable/message.html
 */
abstract class AbstractMessageDialog extends AbstractTextDialog
{
}
