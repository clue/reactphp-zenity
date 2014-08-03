<?php

use React\EventLoop\Factory;
use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Dialog\FileSelectionDialog;
use Clue\React\Zenity\Builder;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);
$builder = new Builder();

$launcher->launch($builder->fileSelection())->then(function (SplFileInfo $file) use ($builder, $launcher) {
    var_dump($file);

    $launcher->launch($builder->info('Selected "' . $file->getFilename() . '". Re-opening dialog with same selection'))->then(function () use ($file, $launcher) {
        $selection = new FileSelectionDialog();
        $selection->setFilename($file);
        $selection->setTitle('Pretend we\'re overwriting the file');
        $selection->setConfirmOverwrite(true);
        $selection->setSave(true);

        $launcher->launch($selection);
    });
});

$loop->run();
