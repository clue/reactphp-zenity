<?php

namespace Clue\Zenity\React;

use React\EventLoop\LoopInterface;
use Icecave\Mephisto\Factory\ProcessFactory;
use Icecave\Mephisto\Launcher\CommandLineLauncher;
use Icecave\Mephisto\Process\ProcessInterface;
use Clue\Zenity\React\Model\Question;
use Clue\Zenity\React\Model\Info;
use Clue\Zenity\React\Model\Warning;
use Clue\Zenity\React\Model\Error;
use Clue\Zenity\React\Model\Entry;
use Clue\Zenity\React\Model\FileSelection;
use Clue\Zenity\React\Model\Progress;
use Clue\Zenity\React\Model\Notification;
use Clue\Zenity\React\Model\TextInfo;
use Clue\Zenity\React\Model\Listing;

/**
 *
 * @link https://github.com/clue/zenity-react
 * @link https://help.gnome.org/users/zenity/stable/index.html.en
 */
class Launcher
{
    private $loop;
    private $processLauncher;
    private $bin = 'zenity';

    public function __construct(LoopInterface $loop, CommandLineLauncher $processLauncher = null)
    {
        if ($processLauncher === null) {
            $processFactory = new ProcessFactory($loop);
            $processLauncher = new CommandLineLauncher($processFactory);
        }

        $this->processLauncher = $processLauncher;
        $this->loop = $loop;
    }

    public function info($text, $title = null)
    {
        $zenity = new Info();
        $zenity->setText($text);
        $zenity->setTitle($title);

        return $zenity->run($this);
    }

    public function warning($text, $title = null)
    {
        $zenity = new Warning();
        $zenity->setText($text);
        $zenity->setTitle($title);

        return $zenity->run($this);
    }

    public function error($text, $title = null)
    {
        $zenity = new Error();
        $zenity->setText($text);
        $zenity->setTitle($title);

        return $zenity->run($this);
    }

    public function question($question, $title = null)
    {
        $zenity = new Question();
        $zenity->setText($question);
        $zenity->setTitle($title);

        return $zenity->run($this);
    }

    public function entry($prompt = null, $prefill = null)
    {
        $zenity = new Entry();
        $zenity->setText($prompt);
        $zenity->setEntryText($prefill);

        return $zenity->run($this);
    }

    public function fileSelection($title = null, $multiple = false)
    {
        $zenity = new FileSelection();
        $zenity->setTitle('Select any file');
        $zenity->setMultiple($multiple);

        return $zenity->run($this);
    }

    public function fileSave($title, $previous = null)
    {
        $zenity = new FileSelection();
        $zenity->setTitle($title);
        $zenity->setFilename($previous);
        $zenity->setSave(true);
        $zenity->setConfirmOverwrite(true);

        return $zenity->run($this);
    }

    public function directorySelection($title = null, $multiple = false)
    {
        $zenity = new FileSelection();
        $zenity->setDirectory(true);
        $zenity->setTitle($title);
        $zenity->setMultiple($multiple);

        return $zenity->run($this);
    }

    public function progress($text = null)
    {
        $zenity = new Progress();
        $zenity->setText($text);
        $zenity->setAutoClose(true);

        return $zenity->run($this);
    }

    public function pulsate($text = null)
    {
        $zenity = new Progress();
        $zenity->setText($text);
        $zenity->setPulsate(true);
        $zenity->setAutoClose(true);

        return $zenity->run($this);
    }

    public function notification($text, $icon = null)
    {
        $zenity = new Notification();
        $zenity->setText($text);
        $zenity->setIcon($icon);

        return $zenity->run($this);
    }

    public function notifier()
    {
        $zenity = new Notification();
        $zenity->setListen(true);

        return $zenity->run($this);
    }

    public function text($filename, $title = null)
    {
        $zenity = new TextInfo();
        $zenity->setFilename($filename);
        $zenity->setTitle($title);

        return $zenity->run($this);
    }

    public function editable($filename, $title = null)
    {
        $zenity = new TextInfo();
        $zenity->setFilename($filename);
        $zenity->setTitle($title);
        $zenity->setEditable(true);

        return $zenity->run($this);
    }

    public function confirmLicense($filename, $confirmation, $title = null)
    {
        $zenity = new TextInfo();
        $zenity->setFilename($filename);
        $zenity->setCheckbox($confirmation);
        $zenity->setTitle($title);

        return $zenity->run($this);
    }

    public function listMenu($list, $text = null)
    {
        $zenity = new Listing();
        $zenity->addColumn('Id', true);
        $zenity->addColumn('Value');
        $zenity->setHideHeader(true);
        $zenity->setText($text);

        $zenity->run($this);

        foreach ($list as $key => $value) {
            $zenity->writeLine($key);
            $zenity->writeLine($value);
        }

        return $zenity;
    }

    public function listRadio($list, $text = null, $selected = null)
    {
        $zenity = new Listing();
        $zenity->addColumn(' ');
        $zenity->addColumn('Id', true);
        $zenity->addColumn('Value');
        $zenity->setHideHeader(true);
        $zenity->setRadiolist(true);
        $zenity->setPrintColumn(2);
        $zenity->setText($text);

        $zenity->run($this);

        foreach ($list as $key => $value) {
            $zenity->writeLine(($selected == $key) ? 'true' : 'false');
            $zenity->writeLine($key);
            $zenity->writeLine($value);
        }

        return $zenity;
    }

    public function listCheck($list, $text = null, $selected = null)
    {
        $zenity = new Listing();
        $zenity->addColumn(' ');
        $zenity->addColumn('Id', true);
        $zenity->addColumn('Value');
        $zenity->setHideHeader(true);
        $zenity->setChecklist(true);
        $zenity->setPrintColumn(2);
        $zenity->setText($text);

        $zenity->run($this);

        foreach ($list as $key => $value) {
            $zenity->writeLine(in_array($key, $selected) ? 'true' : 'false');
            $zenity->writeLine($key);
            $zenity->writeLine($value);
        }

        return $zenity;
    }

    public function table($rows, array $columns = null, $text = null)
    {
        if ($columns === null) {
            $columns = array();

            foreach ($rows as $row) {
                $columns = array_keys($row);
                break;
            }
        }
        $width = count($columns);

        $zenity = new Listing();
        $zenity->addColumn('Id', true);
        foreach ($columns as $column) {
            $zenity->addColumn($column);
        }
        $zenity->setText($text);

        $zenity->run($this);

        foreach ($rows as $id => $row) {
            $zenity->writeLine($id);

            $n = 0;
            foreach ($row as $column) {
                if (++$n > $width) {
                    break;
                }
                $zenity->writeLine($column);
            }
        }

        return $zenity;
    }

    public function setBin($bin)
    {
        $this->bin = $bin;
    }

    public function run($args = array())
    {
        $command = $this->bin;

        foreach ($args as $name => $value) {
            if (is_int($name)) {
                $command .= ' ' . escapeshellarg($value);
            } else {
                $command .= ' --' . $name . '=' . escapeshellarg($value);
            }
        }

        // var_dump($command);

        $process = $this->processLauncher->runCommandLine($command);
        /* @var $process ProcessInterface */
        return $process;
    }
}
