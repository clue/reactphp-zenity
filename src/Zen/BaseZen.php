<?php

namespace Clue\React\Zenity\Zen;

use React\Promise\PromiseInterface;
use React\ChildProcess\Process;

class BaseZen implements PromiseInterface
{
    protected $promise;
    protected $process;

    public function go(PromiseInterface $promise, Process $process)
    {
        $this->promise = $promise;
        $this->process = $process;
    }

    public function then($fulfilledHandler = null, $errorHandler = null, $progressHandler = null)
    {
        return $this->promise->then($fulfilledHandler, $errorHandler, $progressHandler);
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
        if ($this->process === null) return;
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
