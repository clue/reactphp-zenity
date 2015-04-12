<?php

namespace Clue\React\Zenity\Zen;

use React\Promise\PromiseInterface;
use React\ChildProcess\Process;
use React\Promise\Deferred;

class BaseZen implements PromiseInterface
{
    protected $promise;
    protected $deferred;
    protected $process;

    /** @internal */
    public function go(Process $process)
    {
        $this->deferred = $deferred = new Deferred();
        $this->process = $process;

        $buffered = null;
        $process->stdout->on('data', function ($data) use (&$buffered) {
            if ($data !== '') {
                $buffered .= $data;
            }
        });

        $process->on('exit', function($code) use ($deferred) {
            if ($code !== 0) {
                $deferred->reject($code);
            } else {
                $deferred->resolve();
            }
        });

        $that = $this;
        $this->promise = $deferred->promise()->then(function () use (&$buffered, $that) {
            if ($buffered === null) {
                $buffered = true;
            } else {
                $buffered = $that->parseValue(trim($buffered));
            }
            return $buffered;
        });
    }

    public function then($fulfilledHandler = null, $errorHandler = null, $progressHandler = null)
    {
        return $this->promise->then($fulfilledHandler, $errorHandler, $progressHandler);
    }

    public function close()
    {
        $this->deferred->resolve();

        if ($this->process !== null && $this->process->isRunning()) {
            $this->process->terminate(SIGKILL);
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
