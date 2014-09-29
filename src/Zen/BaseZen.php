<?php

namespace Clue\React\Zenity\Zen;

use React\Promise\PromiseInterface;
use React\Promise\Deferred;
use React\ChildProcess\Process;

class BaseZen implements PromiseInterface
{
    private $deferred;
    private $process;

    public function __construct(Deferred $deferred, Process $process)
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
            $this->process->close();
        }

        return $this;
    }

    protected function writeln($line)
    {
        $this->process->stdin->write($line . PHP_EOL);
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
