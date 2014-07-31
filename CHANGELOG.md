# CHANGELOG

This file is a manually maintained list of changes for each release. Feel free
to add your changes here when sending pull requests. Also send corrections if
you spot any mistakes.

## 0.2.0 (2014-07-31)

* BC break: Rename namespace from `Clue\Zenity\React` to `Clue\React\Zenity`
  (#2)
* Feature: Compatibility with PHP 5.3 by using $that reference within closures
  (#1)
* Use PSR-4 code layout
  (#3)

## 0.1.1 (2014-01-24)

* Fix: Work around [an issue](https://bugzilla.gnome.org/show_bug.cgi?id=698683)
  in Zenity 3.8 which essentially broke selecting items from lists (tables,
  menus, radioboxes etc.) via double-click or hitting enter. This workaround is
  safe for both affected and unaffected versions.

## 0.1.0 (2013-09-06)

* First tagged release
