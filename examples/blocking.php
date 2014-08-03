<?php

use React\EventLoop\Factory;
use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Builder;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);
$builder = new Builder();

$name = $launcher->waitFor($builder->entry('Search package'));
if ($name === false) {
    exit;
}

$pulser = $launcher->launch($builder->pulsate('Searching packagist.org for "' . $name . '"...'));
sleep(3);
$pulser->close();

$packages = array('mink', 'behat', 'phpunit', 'box', 'boris');
$pid = $launcher->waitFor($builder->listRadio($packages, 'Select package'));

var_dump($packages[$pid]);
