<?php

use React\EventLoop\Factory;
use Clue\Zenity\React\Launcher;
use Clue\Zenity\React\Model\FileSelection;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);

$notification = $launcher->notification();
$notification->setMessage('Hello world');

$n = 0;
$loop->addPeriodicTimer(10.0, function ($timer) use ($notification, &$n) {
    $notification->setMessage('Hi' . ++$n);
});


$loop->run();
