<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractTextDialog;
use React\Promise\Deferred;
use Icecave\Mephisto\Process\ProcessInterface;
use Clue\React\Zenity\Zen\FormsZen;

/**
 * Use the --forms option to create a forms dialog.
 *
 * The contents of the form fields will be reported back as an array of string values.
 *
 * @link https://help.gnome.org/users/zenity/stable/forms.html
 */
class FormsDialog extends AbstractTextDialog
{
    protected $fields = array();

    // no setter:
    protected $formsDateFormat = '%Y-%m-%d';
    protected $separator = '|||';

    /**
     * Add a new Entry in forms dialog.
     *
     * @param string $name
     * @return self chainable
     */
    public function addEntry($name)
    {
        $this->fields[] = '--add-entry=' . $name;

        return $this;
    }

    /**
     * Add a new Password Entry in forms dialog. (Hide text)
     *
     * @param string $name
     * @return self chainable
     */
    public function addPassword($name)
    {
        $this->fields[] = '--add-password=' . $name;

        return $this;
    }

    /**
     * Add a new Calendar in forms dialog.
     *
     * @param string $name
     * @return self chainable
     */
    public function addCalendar($name)
    {
        $this->fields[] = '--add-calendar=' . $name;

        return $this;
    }

    /**
     * Add a new List in forms dialog.
     *
     * Only one single row can be selected in the list. The default selection is
     * the first row.
     *
     * A simple list can be added like this:
     * <code>
     * $values = array('blue', 'red');
     * $dialog->addList('Favorite color', $values);
     * </code>
     *
     * Selecting a value in this list will return either 'blue' (which is also
     * the default selection) or 'red'.
     *
     * A table can be added like this:
     * <code>
     * $values = array('Nobody', 'nobody@example.com', 'Frank', 'frank@example.org');
     * $dialog->addList('Target', $values, array('Name', 'Email'));
     * </code>
     *
     * The $columns will be uses as headers in the table. If you do not want this,
     * you can pass a `$showHeaders = false` flag. This will present a table
     * to the user with no column headers, so the actual column names will not
     * be visible at all.
     *
     * Selecting a row in this table will return all values in this row
     * concatenated with no separator. The default will be 'Nobodynobody@example.com'.
     * Unfortunately, there does not appear to be a way to change this behavior.
     * You can work around this limitation by adding a unique separator to the
     * field values yourself, for example like this:
     * <code>
     * $values = array('Nobody ', 'nobody@example.com');
     * </code>
     * This will return the string 'Nobody nobody@example.com'.
     *
     * Make sure the values do not contain a "|" character. Internally, this
     * character will be used to separate multiple values from one another.
     * As such, the following two examples are equivalent:
     * <code>
     * $values = array('my|name', 'test');
     * $values = array('my', 'name', 'test');
     * </code>
     * Unfortunately, there does not appear to be a way to change this behavior.
     *
     * Attention, support for lists within forms is somewhat limited. Adding a
     * single list works fine, but anything beyond that will *very* likely
     * either confuse or segfault zenity. Neither the man page nor the online
     * documentation seem to list this feature (2014-08-02), see
     * `zenity --help-forms` for (some) details.
     *
     * @param string       $name
     * @param array        $values
     * @param array|null   $columns
     * @param boolean|null $showHeaders
     * @return self chainable
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

    /**
     * Append all fields to the arguments as-is.
     *
     * @return array
     * @internal
     * @see parent::getArgs()
     */
    public function getArgs()
    {
        return array_merge(parent::getArgs(), $this->fields);
    }

    public function createZen(Deferred $deferred, ProcessInterface $process)
    {
        return new FormsZen($deferred, $process, $this->separator);
    }
}
