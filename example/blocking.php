<?php

use React\EventLoop\Factory;
use Clue\Zenity\React\Launcher;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);

$name = $launcher->entry('Search package')->wait($launcher);
if ($name === false) {
    exit;
}
var_dump($name);

$launcher->pulsateFor(3.0, 'Searching packagist.org for "' . $name . '"...')->wait($launcher);

$packages = array('mink', 'behat', 'phpunit', 'box', 'boris');
$pid = $launcher->listRadio($packages, 'Select package')->wait($launcher);

var_dump($packages[$pid]);
