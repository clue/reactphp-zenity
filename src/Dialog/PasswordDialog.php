<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;
use Clue\React\Zenity\Zen\PasswordZen;

/**
 * Use the --password option to create a password entry dialog.
 *
 * The contents of the password field will be reported back as a string.
 *
 * If the `setUsername(true)` flag is used, the dialog will use two fields for
 * the username and password. The contents of both both fields will be reported
 * back as an array with two strings.
 * <code>
 * $ret = array($username, $password);
 * </code>
 *
 * Internally, Zenity will separate both values with "|" character. As such,
 * there's no way to reliably tell where the username ends and the password
 * starts in a string like "user|name|pass|word". Because it's common to have
 * special characters in the password and usernames tend to be restricted, this
 * library assumes the username ends after the first occurrence:
 * <code>
 * $ret = array('user', 'name|pass|word');
 * </code>
 *
 * This is only a concern if you actually permit the "|" character in passwords.
 * Unfortunately, there does not appear to be a way to change this behavior.
 *
 * @link https://help.gnome.org/users/zenity/stable/password.html.en
 */
class PasswordDialog extends AbstractDialog
{
    protected $username = false;

    /**
     * Display the username field.
     *
     * @param boolean $username
     * @return self chainable
     */
    public function setUsername($username)
    {
        $this->username = !!$username;

        return $this;
    }

    public function createZen()
    {
        return new PasswordZen($this->username);
    }
}
