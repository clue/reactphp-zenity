<?php

require __DIR__ . '/../vendor/autoload.php';

$launcher = new Clue\React\Zenity\Launcher();
$builder = new Clue\React\Zenity\Builder();

$launcher->launch($builder->fileSelection())->then(function (SplFileInfo $file) use ($launcher) {
    var_dump($file);

    $launcher->launch(new Clue\React\Zenity\Dialog\InfoDialog('Selected "' . $file->getFilename() . '". Re-opening dialog with same selection'))->then(function () use ($file, $launcher) {
        $selection = new Clue\React\Zenity\Dialog\FileSelectionDialog();
        $selection->setFilename($file);
        $selection->setTitle('Pretend we\'re overwriting the file');
        $selection->setConfirmOverwrite(true);
        $selection->setSave(true);

        $launcher->launch($selection);
    }, function (Exception $e) {
        echo 'Error: ' . $e->getMessage() . PHP_EOL;
    });
}, function (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
});
