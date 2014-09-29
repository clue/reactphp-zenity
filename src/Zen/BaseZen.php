<?php

namespace Clue\React\Zenity\Zen;

use React\Promise\PromiseInterface;
use React\Promise\Deferred;
use Icecave\Mephisto\Process\ProcessInterface;

class BaseZen implements PromiseInterface
{
    private $deferred;
    private $process;

    public function __construct(Deferred $deferred, ProcessInterface $process)
    {
        $this->deferred = $deferred;
        $this->process = $process;
    }

    public function then($fulfilledHandler = null, $errorHandler = null, $progressHandler = null)
    {
        return $this->deferred->then($fulfilledHandler, $errorHandler, $progressHandler);
    }

    public function close()
    {
        if ($this->process !== null) {
            $this->process->kill();

            $streams = array($this->process->outputStream(), $this->process->inputStream(), $this->process->errorStream());
            foreach ($streams as $stream) {
                if ($stream !== null) {
                    $stream->close();
                }
            }

            // $this->process = null;
        }

        return $this;
    }

    protected function writeln($line)
    {
        $this->process->inputStream()->write($line . PHP_EOL);
    }

    /**
     * Parse the given value from the dialog to the appropriate return value for this dialog
     *
     * @param string $value The raw value received from the dialog window
     * @return mixed The logical value presented to the user
     * @internal
     */
    public function parseValue($value)
    {
        return $value;
    }
}
