<?php

namespace Clue\Zenity\React\Model;

use Clue\Zenity\React\Zenity;

class Password extends Zenity
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
    }

    protected function parseValue($value)
    {
        if ($this->username) {
            return explode(self::SEPARATOR, $value, 2);
        }
        return $value;
    }
}
