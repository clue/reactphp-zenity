<?php

namespace Clue\React\Zenity\Zen;

use Clue\React\Zenity\Zen\BaseZen;

class TextInfoZen extends BaseZen
{
    /**
     * Writes a single line to the TextInfo
     *
     * @param string $line
     * @return self chainable
     */
    public function addLine($line)
    {
        $this->writeln($line);

        return $this;
    }
}
