<?php

require __DIR__ . '/../vendor/autoload.php';

$launcher = new Clue\React\Zenity\Launcher();

$q = new Clue\React\Zenity\Dialog\EntryDialog('What\'s your name?');
$q->setEntryText(getenv('USER'));
$q->setTitle('Enter your name');

$launcher->launch($q)->then(function ($name) use ($launcher) {
    $launcher->launch(new Clue\React\Zenity\Dialog\InfoDialog('Welcome to the introduction of zenity, ' . $name))->then(function () use ($launcher) {
        $launcher->launch(new Clue\React\Zenity\Dialog\QuestionDialog('Do you want to quit?'))->then(function () use ($launcher) {
            $launcher->launch(new Clue\React\Zenity\Dialog\ErrorDialog('Oh noes!'));
        }, function() use ($launcher) {
            $launcher->launch(new Clue\React\Zenity\Dialog\WarningDialog('You should have selected yes!'));
        });
    }, function (Exception $e) {
        echo 'Error: ' . $e->getMessage() . PHP_EOL;
    });
}, function () use ($launcher) {
    $launcher->launch(new Clue\React\Zenity\Dialog\WarningDialog('No name given'));
});
