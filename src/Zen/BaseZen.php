<?php

namespace Clue\React\Zenity\Zen;

use React\Promise\PromiseInterface;
use React\ChildProcess\Process;
use React\Promise\Deferred;

class BaseZen implements PromiseInterface
{
    protected $promise;
    protected $process;

    /** @internal */
    public function go(Process $process)
    {
        $deferred = new Deferred();

        $result = null;
        $process->stdout->on('data', function ($data) use (&$result) {
            if ($data !== '') {
                $result .= $data;
            }
        });

        $that = $this;
        $process->on('exit', function($code) use ($process, $that, &$result, $deferred) {
            if ($code !== 0) {
                $deferred->reject($code);
            } else {
                if ($result === null) {
                    $result = true;
                } else {
                    $result = $that->parseValue(trim($result));
                }
                $deferred->resolve($result);
            }

            $that->close();
        });

        $this->promise = $deferred->promise();
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
