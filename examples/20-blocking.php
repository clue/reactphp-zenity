<?php

require __DIR__ . '/../vendor/autoload.php';

$launcher = new Clue\React\Zenity\Launcher();
$builder = new Clue\React\Zenity\Builder();

$name = $launcher->waitFor(new Clue\React\Zenity\Dialog\EntryDialog('Search package'));
if ($name === false) {
    exit;
}

$pulser = $launcher->launchZen($builder->pulsate('Searching packagist.org for "' . $name . '"...'));
sleep(3);
$pulser->close();

$packages = array('mink', 'behat', 'phpunit', 'box', 'boris');
$pid = $launcher->waitFor($builder->listRadio($packages, 'Select package'));

var_dump($packages[$pid]);
