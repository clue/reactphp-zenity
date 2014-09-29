<?php

namespace Clue\React\Zenity\Zen;

use Clue\React\Zenity\Zen\BaseZen;
use React\Promise\Deferred;
use Icecave\Mephisto\Process\ProcessInterface;

class ListZen extends BaseZen
{
    private $single;
    private $separator;

    public function __construct(Deferred $deferred, ProcessInterface $process, $single, $separator)
    {
        parent::__construct($deferred, $process);

        $this->single = $single;
        $this->separator = $separator;
    }

    /**
     * Parses the string returned from the dialog
     *
     * Usually, this will return a single string.
     *
     * If the `setMultiple(true)` option is active or this is a checklist, this
     * will return an array of strings instead. The size of the array depends on
     * the number of rows selected by the user.
     *
     * @internal
     * @see parent::parseValue()
     * @return string|string[] a single or any number of strings depending on the multiple setting
     * @see ListDialog::setMultiple()
     */
    public function parseValue($value)
    {
        if (trim($value) === '') {
            // TODO: move logic
            return false;
        }

        // always split on separator, even if we only return a single value (explicitly or a checklist)
        // work around an issue in zenity 3.8: https://bugzilla.gnome.org/show_bug.cgi?id=698683
        $value = explode($this->separator, $value);
        if ($this->single) {
            $value = $value[0];
        }
        return $value;
    }
}
