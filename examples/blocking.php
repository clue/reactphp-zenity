<?php

use React\EventLoop\Factory;
use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Dialog\EntryDialog;
use Clue\React\Zenity\Builder\ListBuilder;
use Clue\React\Zenity\Builder\ProgressBuilder;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);

$name = $launcher->waitFor(new EntryDialog('Search package'));
if ($name === false) {
    exit;
}

$builder = new ProgressBuilder();
$pulser = $builder->pulsate('Searching packagist.org for "' . $name . '"...');

$pulsing = $launcher->launch($pulser);

// pretend this is a time consuming task to fetch all packages:
sleep(3);
$packages = array('mink', 'behat', 'phpunit', 'box', 'boris');

$pulsing->close();


$builder = new ListBuilder();
$list = $builder->listRadio($packages, 'Select package');

$pid = $launcher->waitFor($list);

var_dump($packages[$pid]);
