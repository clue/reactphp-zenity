<?php

namespace Clue\React\Zenity\Zen;

use Clue\React\Zenity\Zen\BaseZen;
use React\Promise\Deferred;
use React\ChildProcess\Process;
use SplFileInfo;

class FileSelectionZen extends BaseZen
{
    private $multiple;
    private $separator;

    public function __construct(Deferred $deferred, Process $process, $multiple, $separator)
    {
        parent::__construct($deferred, $process);

        $this->multiple = $multiple;
        $this->separator = $separator;
    }

    /**
     * Parses the path string returned from the dialog into a SplFileInfo object
     *
     * Usually, this will return a single SplFileInfo object.
     *
     * If the `setMultiple(true)` option is active, this will return an array
     * of SplFileInfo objects instead. The size of the array depends on the
     * number of files selected by the user.
     *
     * @internal
     * @see parent::parseValue()
     * @return SplFileInfo|SplFileInfo[] a single or any number of SplFileInfo objects depending on the multiple setting
     * @see FileSelectionDialog::setMultiple()
     */
    public function parseValue($value)
    {
        if ($this->multiple) {
            $ret = array();

            foreach(explode($this->separator, $value) as $path) {
                $ret[] = new SplFileInfo($path);
            }

            return $ret;
        }
        return new SplFileInfo($value);
    }
}
