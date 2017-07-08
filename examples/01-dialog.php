<?php

use React\EventLoop\Factory;
use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Dialog\InfoDialog;
use Clue\React\Zenity\Dialog\QuestionDialog;
use Clue\React\Zenity\Dialog\ErrorDialog;
use Clue\React\Zenity\Dialog\EntryDialog;
use Clue\React\Zenity\Dialog\WarningDialog;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);

$q = new EntryDialog('What\'s your name?');
$q->setEntryText(getenv('USER'));
$q->setTitle('Enter your name');

$launcher->launch($q)->then(function ($name) use ($launcher) {
    $launcher->launch(new InfoDialog('Welcome to the introduction of zenity, ' . $name))->then(function () use ($launcher) {
        $launcher->launch(new QuestionDialog('Do you want to quit?'))->then(function () use ($launcher) {
            $launcher->launch(new ErrorDialog('Oh noes!'));
        }, function() use ($launcher) {
            $launcher->launch(new WarningDialog('You should have selected yes!'));
        });
    });
}, function () use ($launcher) {
    $launcher->launch(new WarningDialog('No name given'));
});

$loop->run();
