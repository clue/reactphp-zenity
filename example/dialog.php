<?php

use React\EventLoop\Factory;
use Clue\Zenity\React\Launcher;
use Clue\Zenity\React\Builder;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);
$builder = new Builder($launcher);

$builder->entry('What\'s your name?', getenv('USER'))->setTitle('Enter your name')->run();

$builder->info('Welcome to the introduction of zenity')->then(function ($ret) use ($builder) {
    var_dump('info', $ret);

    $builder->question('Do you want to quit?')->then(function () use ($builder) {
        $builder->error('Oh noes!');
    }, function() use ($builder) {
        $builder->warning('You should have selected yes!');
    });
});

$builder->warning('Warn')->run();

$loop->run();
