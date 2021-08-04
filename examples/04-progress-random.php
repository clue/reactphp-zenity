<?php

use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Builder;
use React\EventLoop\Loop;

require __DIR__ . '/../vendor/autoload.php';

$launcher = new Launcher();
$builder = new Builder();

$progress = $launcher->launchZen($builder->progress('Pseudo-processing...'));

$progress->setPercentage(50);

$timer = Loop::addPeriodicTimer(0.2, function () use ($progress) {
    $progress->advance(mt_rand(-1, 3));
});

$progress->promise()->then(
    function () use ($timer, $builder, $launcher) {
        $timer->cancel();

        $launcher->launch($builder->info('Done'));
    },
    function() use ($timer) {
        $timer->cancel();
    }
);
