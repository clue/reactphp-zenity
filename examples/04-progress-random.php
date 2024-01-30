<?php

use React\EventLoop\Loop;

require __DIR__ . '/../vendor/autoload.php';

$launcher = new Clue\React\Zenity\Launcher();
$builder = new Clue\React\Zenity\Builder();

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
