<?php

use React\EventLoop\Factory;
use Clue\Zenity\React\Launcher;
use Clue\Zenity\React\Model\FileSelection;
use Clue\Zenity\React\Builder;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);
$builder = new Builder($launcher);

$builder->fileSelection()->then(function (SplFileInfo $file) use ($builder) {
    var_dump($file);

    $builder->info('Selected "' . $file->getFilename() . '". Re-opening dialog with same selection')->then(function () use ($file, $builder) {
        $selection = new FileSelection();
        $selection->setFilename($file);
        $selection->setTitle('Pretend we\'re overwriting the file');
        $selection->setConfirmOverwrite(true);
        $selection->setSave(true);

        $selection->run($builder);
    });
});

$loop->run();
