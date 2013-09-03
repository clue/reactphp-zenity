<?php

use React\EventLoop\Factory;
use Clue\Zenity\React\Launcher;
use Clue\Zenity\React\Builder;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);
$builder = new Builder($launcher);

$builder->entry('What\'s your name?', getenv('USER'));

$builder->info('Welcome to the introduction of zenity')->then(function ($ret) use ($builder) {
    var_dump('info', $ret);

    $builder->question('Do you want to quit?')->then(function ($answer) use ($builder) {
        var_dump('question', $answer);

        if ($answer === false) {
            $builder->warning('You should have selected yes!');
        } else {
            $builder->error('Oh noes!');
        }
    });
});

$builder->warning('Warn');

$loop->run();
