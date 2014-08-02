<?php

namespace Clue\React\Zenity\Builder;

use Clue\React\Zenity\Dialog\QuestionDialog;
use Clue\React\Zenity\Dialog\InfoDialog;
use Clue\React\Zenity\Dialog\WarningDialog;
use Clue\React\Zenity\Dialog\ErrorDialog;

/**
 * For each type, use the --text option to specify the text that is displayed in the dialog.
 *
 * @link https://help.gnome.org/users/zenity/stable/message.html
 *
 * Convenience class used to construct common zenity dialogs
 */
class MessageBuilder
{
    public function info($text, $title = null)
    {
        $zenity = new InfoDialog();
        $zenity->setText($text);
        $zenity->setTitle($title);

        return $zenity;
    }

    public function warning($text, $title = null)
    {
        $zenity = new WarningDialog();
        $zenity->setText($text);
        $zenity->setTitle($title);

        return $zenity;
    }

    public function error($text, $title = null)
    {
        $zenity = new ErrorDialog();
        $zenity->setText($text);
        $zenity->setTitle($title);

        return $zenity;
    }

    public function question($question, $title = null)
    {
        $zenity = new QuestionDialog();
        $zenity->setText($question);
        $zenity->setTitle($title);

        return $zenity;
    }
}
