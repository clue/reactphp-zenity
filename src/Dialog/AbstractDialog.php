<?php

namespace Clue\React\Zenity\Dialog;

use React\Promise\Deferred;
use Icecave\Mephisto\Process\ProcessInterface;
use Clue\React\Zenity\Zen\BaseZen;

abstract class AbstractDialog
{
    private $inbuffer = null;

    protected $title;
    protected $windowIcon;
    protected $timeout;
    protected $modal = false;
    protected $width;
    protected $height;
    protected $okLabel;
    protected $cancelLabel;

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function setWindowIcon($icon)
    {
        $this->windowIcon = $icon;

        return $this;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = (int)$timeout;

        return $this;
    }

    public function setModal($modal)
    {
        $this->modal = !!$modal;

        return $this;
    }

    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    public function setOkLabel($label)
    {
        $this->okLabel = $label;

        return $this;
    }

    public function setCancelLabel($label)
    {
        $this->cancelLabel = $label;

        return $this;
    }

    private function getType()
    {
        // InfoDialog => info
        return $this->decamelize(substr(basename(str_replace('\\', '/', get_class($this))), 0, -6));
    }

    public function getArgs()
    {

        $args = array(
            '--' . $this->getType()
        );

        foreach ($this as $name => $value) {
            if (!in_array($name, array('inbuffer')) && $value !== null && $value !== false && !is_array($value)) {
                $name = $this->decamelize($name);

                if ($name === true) {
                    $args[] = $value;
                } else {
                    $args[$name] = $value;
                }
            }
        }

        return $args;
    }

    protected function decamelize($name)
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $name));
    }

    public function parseValue($value)
    {
        return $value;
    }

    public function createZen(Deferred $deferred, ProcessInterface $process)
    {
        return new BaseZen($deferred, $process);
    }

    protected function writeln($line)
    {
        // buffer input stream temporarily
        $this->inbuffer .= $line . PHP_EOL;
    }

    public function getInBuffer()
    {
        return $this->inbuffer;
    }
}
