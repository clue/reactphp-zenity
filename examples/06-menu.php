<?php

use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Builder;
use Clue\React\Zenity\Dialog\InfoDialog;

require __DIR__ . '/../vendor/autoload.php';

$launcher = new Launcher();
$builder = new Builder();

$main = function() use (&$main, $builder, $launcher) {
    $menu = $builder->listMenu(array('Introduction', 'Tests', 'License', 'Bugs / Issues'), 'Main menu');
    $menu->setWindowIcon('info');
    $menu->setTitle('Main menu');

    $launcher->launch($menu)->then(function ($selected) use ($builder, $main, $launcher) {
        if ($selected === '0') {
            // U+2212 MINUS SIGN for alignment
            $launcher->launch($builder->listRadio(array('+2', '+1', '±0', '−1', '−2'), 'Introduction Level', 2))->then(function ($level) use ($main, $launcher) {
                $launcher->launch(new InfoDialog('Level ' . var_export($level, true)))->then($main, $main);
            }, $main);
        } elseif ($selected === '1') {
            $launcher->launch($builder->listCheck(array('Unit', 'Functional', 'Acceptance (slow)'), 'Selected test suits to run', array(0, 1)))->then(function ($tests) use ($main, $launcher) {
                $launcher->launch(new InfoDialog('Tests: ' . var_export($tests, true)))->then($main, $main);
            }, $main);
        } elseif ($selected === '2') {
            $launcher->launch($builder->confirmLicense(__DIR__ . '/../README.md', 'I have read the README.md file'))->then(function ($checked) use ($main, $launcher) {
                $launcher->launch(new InfoDialog('Clicked ' . var_export($checked, true)))->then($main, $main);
            }, $main);
        } elseif ($selected === '3') {
            $launcher->launch($builder->table(
                array(
                    5123 => array('5123', 'Resolve Random Issue', 'open'),
                    5124 => array('5124', 'Implement demo menu', 'done')
                ),
                array(
                    'Bug ID',
                    'Description',
                    'Status'
                )
            ))->then(function ($bug) use ($main, $builder, $launcher) {
                $pulser = $launcher->launch($builder->pulsate('Loading bug #' . $bug . '...' . PHP_EOL . '(This will not actually do anything...)'));
                $pulser->then($main, $main);
            }, $main);
        } else {
            $launcher->launch(new InfoDialog('Selected ' . var_export($selected, true)))->then($main, $main);
        }
    });
};

$main();
