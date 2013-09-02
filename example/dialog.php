<?php

use React\EventLoop\Factory;
use Clue\Zenity\React\Launcher;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);

$launcher->entry('What\'s your name?', getenv('USER'));

$launcher->info('Welcome to the introduction of zenity')->then(function ($ret) use ($launcher) {
    var_dump('info', $ret);

    $launcher->question('Do you want to quit?')->then(function ($answer) use ($launcher) {
        var_dump('question', $answer);

        if ($answer === false) {
            $launcher->warning('You should have selected yes!');
        } else {
            $launcher->error('Oh noes!');
        }
    });
});

$launcher->warning('Warn');

$loop->run();
