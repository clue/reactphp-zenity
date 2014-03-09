<?php

use React\EventLoop\Factory;
use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Builder;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);
$builder = new Builder();

$progress = $launcher->launch($builder->pulsate('Pseudo-processing...'));

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

$timer = $loop->addPeriodicTimer(2.0, function ($timer) use ($progress, $texts) {
    static $i = 0;

    if (isset($texts[$i])) {
        $text = $texts[$i++];
        $text = '[' . $i . '/' . count($texts) . '] ' . $text . '...';

        $progress->setText($text);
    } else {
        $progress->complete();
    }
});

$progress->then(function () use ($timer, $builder, $launcher) {
    $timer->cancel();

    $launcher->launch($builder->info('Done'));
});

$progress->then(null, function() use ($timer, $builder, $launcher) {
    $timer->cancel();

    $launcher->launch($builder->error('Canceled'));
});

$loop->run();
