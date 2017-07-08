<?php

use React\EventLoop\Factory;
use Clue\React\Zenity\Launcher;
use Clue\React\Zenity\Dialog\FormsDialog;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();
$launcher = new Launcher($loop);

$form = new FormsDialog();
$form->setWindowIcon('info');
$form->setText('Enter user information');

$form->addEntry('Name');
$form->addPassword('Password');
$form->addCalendar('Birthday');
//$form->addList('Group', array('Admin', 'User', 'Random'));
$form->addEntry('Nickname');
$form->addList('Gender', array('Male', 10, 'Female', 0), array('Gender', 'Number'));

$launcher->launch($form)->then(function($result) {
    var_dump('result', $result);
}, function() {
    var_dump('form canceled');
});

$loop->run();
