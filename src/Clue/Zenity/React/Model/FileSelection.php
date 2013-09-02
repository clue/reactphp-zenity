<?php

namespace Clue\Zenity\React\Model;

use Clue\Zenity\React\Zenity;

class FileSelection extends Zenity
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
    }

    public function setMultiple($multiple)
    {
        $this->multiple = !!$multiple;
    }

    /**
     * whether to enable directoy selection mode
     *
     * @param boolean $directory
     */
    public function setDirectory($directory)
    {
        $this->directory = !!$directory;
    }

    public function setSave($save)
    {
        $this->save = !!$save;
    }

    public function setConfirmOverwrite($confirm)
    {
        $this->confirmOverwrite = !!$confirm;
    }

    public function setFileFilter($filter)
    {
        $this->fileFilter = $filter;
    }

    protected function parseValue($value)
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
