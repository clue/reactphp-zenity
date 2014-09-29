<?php

namespace Clue\React\Zenity\Zen;

use Clue\React\Zenity\Zen\BaseZen;
use React\Promise\Deferred;
use Icecave\Mephisto\Process\ProcessInterface;

class PasswordZen extends BaseZen
{
    /** @var string */
    const SEPARATOR = '|';

    private $username;

    public function __construct(Deferred $deferred, ProcessInterface $process, $username)
    {
        parent::__construct($deferred, $process);

        $this->username = $username;
    }

    /**
     * Parses the string returned from the dialog
     *
     * Usually, this will return a single password string.
     *
     * If the `setUsername(true)` option is active, this will return an array
     * of string username and string password.
     *
     * @internal
     * @see parent::parseValue()
     * @return string|string[] a single password string or an array($user, $pass) depending on the username setting
     * @see PasswordDialog::setUsername()
     */
    public function parseValue($value)
    {
        if ($this->username) {
            return explode(self::SEPARATOR, $value, 2);
        }
        return $value;
    }
}
