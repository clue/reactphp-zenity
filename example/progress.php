<?php

use React\EventLoop\Factory;
use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Builder;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);
$builder = new Builder();

$progress = $launcher->launch($builder->progress('Pseudo-processing...'));

$loop->addPeriodicTimer(0.1, function ($timer) use ($progress) {
    $progress->advance(mt_rand(0, 3));

    if ($progress->getPercentage() >= 100) {
        $timer->cancel();
    }
});

$pulsate = $launcher->launch($builder->pulsate('[1/3] Preparing...'));

$loop->addTimer(2, function() use ($pulsate) {
    $pulsate->setText('[2/3] Downloading...');
});

$loop->addtimer(4, function() use ($pulsate) {
    $pulsate->setText('[3/3] Unpacking...');
});

$loop->addTimer(6, function() use ($pulsate) {
    $pulsate->complete();
});

$launcher->launch($builder->info('Quit "Processing"?'))->then(function () use ($pulsate) {
    $pulsate->close();
});

$loop->run();
