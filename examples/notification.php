<?php

use React\EventLoop\Factory;
use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Builder;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);
$builder = new Builder();

$notification = $builder->notifier();
$zen = $launcher->launchZen($notification);

$zen->setMessage('Hello world');

$n = 0;
$loop->addPeriodicTimer(10.0, function ($timer) use ($zen, &$n) {
    $zen->setMessage('Hi' . ++$n);
});

$loop->run();
