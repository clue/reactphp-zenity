<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;
use SplFileInfo;

/**
 * Use the --file-selection option to create a file selection dialog.
 *
 * The selected files or directories will be reported back as a SplFileInfo instance.
 * The default mode of the file selection dialog is open.
 *
 * @link https://help.gnome.org/users/zenity/stable/file-selection.html
 */
class FileSelectionDialog extends AbstractDialog
{
    protected $filename;
    protected $multiple = false;
    protected $directory = false;
    protected $save = false;
    protected $confirmOverwrite = false;
    protected $fileFilter;

    // --separator=SEPARATOR
    protected $separator = '|||';

    /**
     * Specifies the file or directory that is selected in the file selection dialog when the dialog is first shown.
     *
     * Accepts either a string or a SplFileInfo instance (such as one returned
     * from a previous FileSelectionDialog).
     *
     * @param string|SplFileInfo $filename
     * @return self chainable
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Allows the selection of multiple filenames in the file selection dialog.
     *
     * Depending on this setting, the dialog will either return a single
     * SplFileInfo or an array of SplFileInfo objects for each selected file.
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
     * Allows only selection of directories in the file selection dialog.
     *
     * The default is to only allow selecting files.
     *
     * @param boolean $directory
     * @return self chainable
     */
    public function setDirectory($directory)
    {
        $this->directory = !!$directory;

        return $this;
    }

    /**
     * Set the file selection dialog into save mode.
     *
     * The default mode of the file selection dialog is open.
     *
     * @param boolean $save
     * @return self chainable
     */
    public function setSave($save)
    {
        $this->save = !!$save;

        return $this;
    }


    /**
     * Confirm file selection if filename already exists
     *
     * Setting this open only has an effect if the dialog is in save mode, so
     * make sure to call `setSave(true)`.
     *
     * @param boolean $confirm
     * @return self chainable
     * @see self::setSave()
     */
    public function setConfirmOverwrite($confirm)
    {
        $this->confirmOverwrite = !!$confirm;

        return $this;
    }

    /**
     * Sets the filename filter.
     *
     * Only files matching this filter will be presented to the user.
     *
     * @param string $filter
     * @return self chainable
     */
    public function setFileFilter($filter)
    {
        $this->fileFilter = $filter;

        return $this;
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
     * @see self::setMultiple()
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
