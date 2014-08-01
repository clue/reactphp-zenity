<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;

class FormsDialog extends AbstractDialog
{
    protected $fields = array();

    protected $text;

    // no setter:
    protected $formsDateFormat = '%Y-%m-%d';
    protected $separator = '|||';

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function addEntry($name)
    {
        $this->fields[] = '--add-entry=' . $name;

        return $this;
    }

    public function addPassword($name)
    {
        $this->fields[] = '--add-password=' . $name;

        return $this;
    }

    public function addCalendar($name)
    {
        $this->fields[] = '--add-calendar=' . $name;

        return $this;
    }

    /**
     *
     * Attention, support for lists within forms is somewhat limited. Adding a
     * single list works fine, but anything beyond that will *very* likely
     * either confuse or segfault zenity. Neither the man page nor the online
     * documentation seem to list this feature (2013-09-02), see
     * `zenity --help-forms` for (some) details.
     *
     * @param string       $name
     * @param array        $values
     * @param array|null   $columns
     * @param boolean|null $showHeaders
     * @link https://mail.gnome.org/archives/commits-list/2011-October/msg04739.html
     */
    public function addList($name, array $values, array $columns = null, $showHeaders = null)
    {

        $this->fields[] = '--add-list=' . $name;

        $this->fields[] = '--list-values=' . implode('|', $values);

        // columns given => show headers if it's not explicitly disabled
        if ($columns !== null && $showHeaders === null) {
            $showHeaders = true;
        }

        if ($showHeaders) {
            $this->fields[] = '--show-header';
        }

        if ($columns !== null) {
            $this->fields[] = '--column-values=' . implode('|', $columns);
        }

        return $this;
    }

    public function getArgs()
    {
        return array_merge(parent::getArgs(), $this->fields);
    }

    public function parseValue($value)
    {
        // TODO: parse passwords
        return explode($this->separator, $value);
    }
}
