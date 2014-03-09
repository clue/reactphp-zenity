<?php

use React\EventLoop\Factory;
use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Builder;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);
$builder = new Builder();

$progress = $launcher->launch($builder->progress('Pseudo-processing...'));

$progress->setPercentage(50);

$timer = $loop->addPeriodicTimer(0.2, function () use ($progress) {
    $progress->advance(mt_rand(-1, 3));
});

$progress->then(function () use ($timer, $builder, $launcher) {
    $timer->cancel();

    $launcher->launch($builder->info('Done'));
});

$progress->then(null, function() use ($timer) {
    $timer->cancel();
});

$loop->run();
