<?php

use React\EventLoop\Factory;
use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Builder;
use Clue\React\Zenity\Dialog\EntryDialog;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);
$builder = new Builder();

$name = $launcher->waitFor(new EntryDialog('Search package'));
if ($name === false) {
    exit;
}

$pulser = $launcher->launch($builder->pulsate('Searching packagist.org for "' . $name . '"...'));
sleep(3);
$pulser->close();

$packages = array('mink', 'behat', 'phpunit', 'box', 'boris');
$pid = $launcher->waitFor($builder->listRadio($packages, 'Select package'));

var_dump($packages[$pid]);
