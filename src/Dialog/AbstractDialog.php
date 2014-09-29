<?php

namespace Clue\React\Zenity\Dialog;

use React\Promise\Deferred;
use Icecave\Mephisto\Process\ProcessInterface;
use Clue\React\Zenity\Zen\BaseZen;

/**
 * Abstract base for all dialog windows.
 *
 * This class defines the common options for all concrete dialog types.
 *
 * @link https://help.gnome.org/users/zenity/stable/index.html#dialogs
 */
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

    /**
     * Specifies the title of the dialog.
     *
     * @param string $title
     * @return self chainable
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Specifies the icon that is displayed in the window frame of the dialog.
     *
     * There are 4 stock icons also available by providing the following keywords:
     * - 'info',
     * - 'warning',
     * - 'question' and
     * - 'error'.
     *
     * @param string $icon
     * @return self chainable
     */
    public function setWindowIcon($icon)
    {
        $this->windowIcon = $icon;

        return $this;
    }

    /**
     * Specifies the timeout in seconds after which the dialog is closed.
     *
     * @param int $timeout
     * @return self chainable
     */
    public function setTimeout($timeout)
    {
        $this->timeout = (int)$timeout;

        return $this;
    }

    /**
     * Sets the modal hint.
     *
     * A model window is forced to be in the foreground. The modal window is a
     * child window that requires users to interact with it before they can
     * return to operating the parent application.
     *
     * @param boolean $modal
     * @return self chainable
     * @link http://en.wikipedia.org/wiki/Modal_window
     */
    public function setModal($modal)
    {
        $this->modal = !!$modal;

        return $this;
    }

    /**
     * Specifies the width of the dialog.
     *
     * @param int $width
     * @return self chainable
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Specifies the height of the dialog.
     *
     * @param int $height
     * @return self chainable
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Sets the label of the Ok button
     *
     * @param string $label
     * @return self chainable
     */
    public function setOkLabel($label)
    {
        $this->okLabel = $label;

        return $this;
    }

    /**
     * Sets the label of the Cancel button
     *
     * @param string $label
     * @return self chainable
     */
    public function setCancelLabel($label)
    {
        $this->cancelLabel = $label;

        return $this;
    }

    /**
     * Gets the type of this dialog.
     *
     * The type is the main argument passed to zentiy to control the type of
     * dialog that is shown.
     *
     * Internally, this is automatically derived from the class name of the
     * dialog instance. E.g. an "InfoDialog" instance will be of type "info".
     *
     * @return string
     */
    private function getType()
    {
        // InfoDialog => info
        return $this->decamelize(substr(basename(str_replace('\\', '/', get_class($this))), 0, -6));
    }

    /**
     * Returns an array of arguments to pass to the zenity bin to produce the current dialog.
     *
     * Internally, this will automatically fetch all properties of the current
     * instance and format them accordingly to zenity arguments.
     *
     * @return string[]
     * @internal
     */
    public function getArgs()
    {
        $args = array(
            '--' . $this->getType()
        );

        foreach ($this as $name => $value) {
            if (!in_array($name, array('inbuffer')) && $value !== null && $value !== false && !is_array($value)) {
                $name = $this->decamelize($name);

                if ($value !== true) {
                    // append value if this is not a boolean arg
                    $name .= '=' . $value;
                }

                // all arguments start with a double dash
                $args []= '--' . $name;
            }
        }

        return $args;
    }

    /**
     * Convert given CamelCase string to hyphen-separated string
     *
     * @param string $name the string in CamelCase notation (AnExample)
     * @return string the string in hyphen-separated notation (an-example)
     */
    protected function decamelize($name)
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $name));
    }

    /**
     * Create a dialog handler to process the results for this dialog.
     *
     * @param Deferred $deferred
     * @param ProcessInterface $process
     * @return BaseZen
     * @internal
     */
    public function createZen(Deferred $deferred, ProcessInterface $process)
    {
        return new BaseZen($deferred, $process);
    }

    /**
     * Write a line of text to the dialog when it is launched.
     *
     * The string is temporarily buffered here and will be passed to the zenity
     * process when invoking the Launcher.
     *
     * @param string $line
     */
    protected function writeln($line)
    {
        // buffer input stream temporarily
        $this->inbuffer .= $line . PHP_EOL;
    }

    /**
     * Get buffered text to write to STDIN of the zenity process representing this dialog.
     *
     * @return string
     * @internal
     * @see self::writeln()
     */
    public function getInBuffer()
    {
        return $this->inbuffer;
    }
}
