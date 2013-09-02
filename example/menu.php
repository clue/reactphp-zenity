<?php

use React\EventLoop\Factory;
use Clue\Zenity\React\Launcher;
use Clue\Zenity\React\Model\FileSelection;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);

$main = function() use (&$main, $launcher) {
    $menu = $launcher->listMenu(array('Introduction', 'Tests', 'License', 'Bugs / Issues'), 'Main menu');

    $menu->then(function ($selected) use ($launcher, $main) {
        if ($selected === '0') {
            // U+2212 MINUS SIGN for alignment
            $launcher->listRadio(array('+2', '+1', '±0', '−1', '−2'), 'Introduction Level', 2)->then(function ($level) use ($main, $launcher) {
                if ($level === false) {
                    $main();
                } else {
                    $launcher->info('Level ' . var_export($level, true))->then($main);
                }
            });
        } elseif ($selected === '1') {
            $launcher->listCheck(array('Unit', 'Functional', 'Acceptance (slow)'), 'Selected test suits to run', array(0, 1))->then(function ($tests) use ($main, $launcher) {
                if ($tests === false) {
                    $main();
                } else {
                    $launcher->info('Tests: ' . var_export($tests, true))->then($main);
                }
            });
        } elseif ($selected === '2') {
            $launcher->confirmLicense(__DIR__ . '/../README.md', 'I have read the README.md file')->then(function ($checked) use ($main, $launcher) {
                if ($checked === false) {
                    $main();
                } else {
                    $launcher->info('Clicked ' . var_export($checked, true))->then($main);
                }
            });
        } elseif ($selected === '3') {
            $launcher->table(
                array(
                    5123 => array('5123', 'Resolve Random Issue', 'open'),
                    5124 => array('5124', 'Implement demo menu', 'done')
                ),
                array(
                    'Bug ID',
                    'Description',
                    'Status'
                )
            )->then(function ($bug) use ($main, $launcher) {
                if ($bug === false) {
                    $main();
                } else {
                    $pulser = $launcher->pulsate('Loading bug #' . $bug . '...' . PHP_EOL . '(This will not actually do anything...)');
                    $pulser->then($main);
                }
            });
        } elseif ($selected !== false) {
            $launcher->info('Selected ' . var_export($selected, true))->then($main);
        }
    });
};

$main();

$loop->run();
