<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractTextDialog;
use React\Promise\Deferred;
use Icecave\Mephisto\Process\ProcessInterface;
use Clue\React\Zenity\Zen\ListZen;

/**
 * Use the --list option to create a list dialog.
 *
 * The contents of the first column of the selected row will be reported back as
 * the selected string value.
 *
 * Data for the dialog must specified column by column, row by row.
 *
 * If you use the --checklist or --radiolist options, each row must start with
 * either 'TRUE' or 'FALSE'.
 *
 * @link https://help.gnome.org/users/zenity/stable/list.html
 */
class ListDialog extends AbstractTextDialog
{
    protected $checklist = false;
    protected $radiolist = false;
    protected $imagelist = false;

    // no setters:
    protected $columns = array();
    protected $separator = '|||';

    protected $multiple = false;
    protected $editable = false;
    protected $printColumn;
    protected $hideHeader = false;

    /**
     * Adds a new column (with the given header name) in the list dialog.
     *
     * Any number of columns can be added to the dialog (at least one, obviously).
     *
     * The $column will be used as header (title) for this column.
     *
     * A hidden (internal) column can be added by passing the `$hide = true`
     * flag. This row will not be displayed at all, but can still be used to
     * access its values. This is often useful for passing hidden IDs in the
     * first column.
     *
     * @param string $column
     * @param boolean $hide
     * @return self chainable
     */
    public function addColumn($column, $hide = false)
    {
        $this->columns[] = '--column=' . $column;

        if ($hide) {
            // this will break
            $this->columns[] = '--hide-column=' . count($this->columns);
        }

        return $this;
    }

    /**
     * Specifies that the first column in the list dialog contains check boxes.
     *
     * A checklist always allows selecting multiple rows, irrespective of the
     * setMultiple() option.
     *
     * @param boolean $check
     * @return self chainable
     */
    public function setChecklist($check)
    {
        $this->checklist = !!$check;

        return $this;
    }

    /**
     * Specifies that the first column in the list dialog contains radio boxes.
     *
     * A radiolist only ever allows selecting a single row, irrespective of the
     * setMultiple() option.
     *
     * @param boolean $radio
     * @return self chainable
     */
    public function setRadiolist($radio)
    {
        $this->radiolist = !!$radio;

        return $this;
    }

    /**
     * Use an image for first column
     *
     * @param boolean $image
     * @return self chainable
     */
    public function setImagelist($image)
    {
        $this->imagelist = !!$image;

        return $this;
    }

    /**
     * Allow multiple rows to be selected
     *
     * @param boolean $multiple
     * @return self chainable
     */
    public function setMultiple($multiple)
    {
        $this->multiple = !!$multiple;

        return $this;
    }

    /**
     * Allow changes to text.
     *
     * This allows all text values in the list to be edited. However, keep in
     * mind that the changed values are not reported back by default:
     *
     * * Only the first column will usually be returned in the output. So if you
     *   allow editing in tables with multiple columns, consider using
     *   `setPrintColumn('ALL')` to return the whole line.
     *
     * * Only selected lines will be returned in the output. So consider using
     *   `setMultiple(true)` to allow selecting multiple lines.
     *
     * Keep in mind that usability is somewhat limited. One can still edit text
     * values in row 1 and only selected row 2 for submission. Unfortunately,
     * there does not appear a way to change this behavior.
     *
     * @param unknown $editable
     * @return self chainable
     */
    public function setEditable($editable)
    {
        $this->editable = !!$editable;

        return $this;
    }

    /**
     * Specifies what column should be printed out upon selection.
     *
     * The default column is '1'. 'ALL' can be used to print out all columns in the list.
     *
     * @param int|string $column
     * @return self chainable
     */
    public function setPrintColumn($column)
    {
        $this->printColumn = $column;

        return $this;
    }

    /**
     * Hides the column headers.
     *
     * @param boolean $hide
     * @return self chainable
     */
    public function setHideHeader($hide)
    {
        $this->hideHeader = !!$hide;

        return $this;
    }

    /**
     * Writes a single value to the buffer.
     *
     * The values will be passed to the zenity instance when the dialog is
     * launched.
     *
     * @param string $line
     * @return self chainable
     */
    public function writeLine($line)
    {
        $this->writeln($line);

        return $this;
    }

    /**
     * Include column definitions in command args
     *
     * @return array
     * @internal
     * @see parent::getArgs()
     */
    public function getArgs()
    {
        return array_merge(parent::getArgs(), $this->columns);
    }

    public function createZen(Deferred $deferred, ProcessInterface $process)
    {
        $single = (!$this->multiple && !$this->checklist);

        return new ListZen($deferred, $process, $single, $this->separator);
    }
}
