<?php

use React\EventLoop\Factory;
use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Builder;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);
$builder = new Builder();

$launcher->launch($builder->entry('What\'s your name?', getenv('USER'))->setTitle('Enter your name'))->then(function ($name) use ($builder, $launcher) {
    $launcher->launch($builder->info('Welcome to the introduction of zenity, ' . $name))->then(function () use ($builder, $launcher) {
        $launcher->launch($builder->question('Do you want to quit?'))->then(function () use ($builder, $launcher) {
            $launcher->launch($builder->error('Oh noes!'));
        }, function() use ($builder, $launcher) {
            $launcher->launch($builder->warning('You should have selected yes!'));
        });
    });
}, function () use ($builder, $launcher) {
    $launcher->launch($builder->warning('No name given'));
});

$loop->run();
