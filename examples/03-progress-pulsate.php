<?php

use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Builder;
use React\EventLoop\Loop;

require __DIR__ . '/../vendor/autoload.php';

$launcher = new Launcher();
$builder = new Builder();

$progress = $launcher->launchZen($builder->pulsate('Pseudo-processing...'));

$texts = array(
    'Preparing',
    'Downloading',
    'Unpacking',
    'Patching',
    'Bootstrapping',
    'Building',
    'Cleaning',
    'Finishing'
);

$timer = Loop::addPeriodicTimer(2.0, function ($timer) use ($progress, $texts) {
    static $i = 0;

    if (isset($texts[$i])) {
        $text = $texts[$i++];
        $text = '[' . $i . '/' . count($texts) . '] ' . $text . '...';

        $progress->setText($text);
    } else {
        $progress->complete();
    }
});

$progress->promise()->then(function () use ($timer, $builder, $launcher) {
    $timer->cancel();

    $launcher->launch($builder->info('Done'));
});

$progress->promise()->then(null, function() use ($timer, $builder, $launcher) {
    $timer->cancel();

    $launcher->launch($builder->error('Canceled'));
});
