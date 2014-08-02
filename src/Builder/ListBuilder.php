<?php

namespace Clue\React\Zenity\Builder;

use Clue\React\Zenity\Dialog\ListDialog;

class ListBuilder
{
    public function listMenu($list, $text = null)
    {
        $zenity = new ListDialog();
        $zenity->addColumn('Id', true);
        $zenity->addColumn('Value');
        $zenity->setHideHeader(true);
        $zenity->setText($text);

        // $zenity->run();

        foreach ($list as $key => $value) {
            $zenity->writeLine($key);
            $zenity->writeLine($value);
        }

        return $zenity;
    }

    public function listRadio($list, $text = null, $selected = null)
    {
        $zenity = new ListDialog();
        $zenity->addColumn(' ');
        $zenity->addColumn('Id', true);
        $zenity->addColumn('Value');
        $zenity->setHideHeader(true);
        $zenity->setRadiolist(true);
        $zenity->setPrintColumn(2);
        $zenity->setText($text);

        // $zenity->run();

        foreach ($list as $key => $value) {
            $zenity->writeLine(($selected == $key) ? 'true' : 'false');
            $zenity->writeLine($key);
            $zenity->writeLine($value);
        }

        return $zenity;
    }

    public function listCheck($list, $text = null, $selected = null)
    {
        $zenity = new ListDialog();
        $zenity->addColumn(' ');
        $zenity->addColumn('Id', true);
        $zenity->addColumn('Value');
        $zenity->setHideHeader(true);
        $zenity->setChecklist(true);
        $zenity->setPrintColumn(2);
        $zenity->setText($text);

        // $zenity->run();

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

        $zenity = new ListDialog();
        $zenity->addColumn('Id', true);
        foreach ($columns as $column) {
            $zenity->addColumn($column);
        }
        $zenity->setText($text);

        // $zenity->run();

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
}
