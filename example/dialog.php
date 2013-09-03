<?php

use React\EventLoop\Factory;
use Clue\Zenity\React\Launcher;
use Clue\Zenity\React\Builder;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);
$builder = new Builder($launcher);

$builder->entry('What\'s your name?', getenv('USER'))->setTitle('Enter your name')->then(function ($name) use ($builder) {
    $builder->info('Welcome to the introduction of zenity, ' . $name)->then(function () use ($builder) {
        $builder->question('Do you want to quit?')->then(function () use ($builder) {
            $builder->error('Oh noes!')->run();
        }, function() use ($builder) {
            $builder->warning('You should have selected yes!')->run();
        });
    });
}, function () use ($builder) {
    $builder->warning('No name given')->run();
});

$loop->run();
