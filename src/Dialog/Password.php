<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;

class Password extends AbstractDialog
{
    /**
     * attention: there's no way to chance this separator character
     *
     * @var string
     */
    const SEPARATOR = '|';

    protected $username = false;

    public function setUsername($username)
    {
        $this->username = !!$username;

        return $this;
    }

    public function parseValue($value)
    {
        if ($this->username) {
            return explode(self::SEPARATOR, $value, 2);
        }
        return $value;
    }
}
