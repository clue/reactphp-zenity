<?php

use React\EventLoop\Factory;
use Clue\Zenity\React\Launcher;
use Clue\Zenity\React\Builder;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);
$builder = new Builder($launcher);

$name = $builder->entry('Search package')->wait($launcher);
if ($name === false) {
    exit;
}
var_dump($name);

$builder->pulsateFor(3.0, 'Searching packagist.org for "' . $name . '"...')->wait($launcher);

$packages = array('mink', 'behat', 'phpunit', 'box', 'boris');
$pid = $builder->listRadio($packages, 'Select package')->wait($launcher);

var_dump($packages[$pid]);
