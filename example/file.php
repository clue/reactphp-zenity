<?php

use React\EventLoop\Factory;
use Clue\Zenity\React\Launcher;
use Clue\Zenity\React\Model\FileSelection;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);

$launcher->fileSelection()->then(function (SplFileInfo $file) use ($launcher) {
    var_dump($file);

    $launcher->info('Selected "' . $file->getFilename() . '". Re-opening dialog with same selection')->then(function () use ($file, $launcher) {
        $selection = new FileSelection();
        $selection->setFilename($file);
        $selection->setTitle('Pretend we\'re overwriting the file');
        $selection->setConfirmOverwrite(true);
        $selection->setSave(true);

        $selection->run($launcher);
    });
});

$loop->run();
