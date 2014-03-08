<?php

namespace Clue\React\Zenity\Dialog;

use Clue\React\Zenity\Dialog\AbstractDialog;

class FileSelection extends AbstractDialog
{
    protected $filename;
    protected $multiple = false;
    protected $directory = false;
    protected $save = false;
    protected $confirmOverwrite = false;
    protected $fileFilter;

    // --separator=SEPARATOR
    protected $separator = '|||';

    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    public function setMultiple($multiple)
    {
        $this->multiple = !!$multiple;

        return $this;
    }

    /**
     * whether to enable directoy selection mode
     *
     * @param boolean $directory
     */
    public function setDirectory($directory)
    {
        $this->directory = !!$directory;

        return $this;
    }

    public function setSave($save)
    {
        $this->save = !!$save;

        return $this;
    }

    public function setConfirmOverwrite($confirm)
    {
        $this->confirmOverwrite = !!$confirm;

        return $this;
    }

    public function setFileFilter($filter)
    {
        $this->fileFilter = $filter;

        return $this;
    }

    public function parseValue($value)
    {
        if ($this->multiple) {
            $ret = array();

            foreach(explode($this->separator, $value) as $path) {
                $ret[] = new \SplFileInfo($path);
            }

            return $ret;
        }
        return new \SplFileInfo($value);
    }
}
