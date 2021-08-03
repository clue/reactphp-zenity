<?php

use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Builder;
use React\EventLoop\Loop;

require __DIR__ . '/../vendor/autoload.php';

$launcher = new Launcher();
$builder = new Builder();

$notification = $builder->notifier();
$zen = $launcher->launchZen($notification);

$zen->setMessage('Hello world');

$n = 0;
Loop::addPeriodicTimer(10.0, function ($timer) use ($zen, &$n) {
    static $icons = array('error', 'warning', 'info', '');
    $zen->setIcon($icons[array_rand($icons)]);

    $zen->setMessage('Hi' . ++$n);
});
