# CHANGELOG

This file is a manually maintained list of changes for each release. Feel free
to add your changes here when sending pull requests. Also send corrections if
you spot any mistakes.

## 0.3.0 (2014-09-xx)

* BC break: Rename all classes in `Clue\Zenity\React\Model\Name` to `Clue\Zenity\React\Dialog\NameDialog`
  (#10)
  * For example, renamed `Model\Info` to `Dialog\InfoDialog`
  * Base `Zenity` renamed to `Dialog\AbstractDialog`
  * Hacky name `Model\Listing` renamed to `Dialog\ListDialog`
  * Fix `Model\ScaleDialog` to now actually work

* BC break: Move launching logic from `Dialog` to `Launcher`
  (#11)
  * The `Dialog` now reprents the dialog option setup, the `Launcher` represents a running instance (process) of the given dialog setup. Clear distinction between setup and the actual process.
  * Running a single `Dialog` setup multiple times or changing settings after launching the first instance is now handled gracefully.
  * Simplified `Builder` and `Dialog` constructors to no longer require a `Launcher` instance.
  * Moved `Dialog::run()` to `Launcher::launch($dialog)`
  * Moved `Dialog::waitReturn()` to `Launcher::waitFor($dialog)`
  
  ```php
  // old
  $dialog = new Model\Info($launcher);
  $dialog->run();
  
  // new
  $dialog = new Dialog\InfoDialog();
  $launcher->launch($dialog);
  ```
  
* BC break: Add dedicated runtime processors for each dialog type
  (#28)
  * Clear distinction between which settings are part of the setup and which settings can be invoked at runtime to update an existing dialog process.

  * `TextInfoDialog`
    * TextInfoDialog::writeLine() renamed to TextInfoDialog::addLine()
    * Add TextInfoZen::addLine()

  * `NotificationDialog`
    * Moved NotificationDialog::setIcon(), setVisible(), setMessage(), setTooltip() to NotificationZen
    * Builder::notification() no longer accepts an optional $icon parameter

  * `ProgressDialog`
    * Moved ProgressDialog::advance(), complete(), getPercentage() to NotificationZen
    * Add ProgressZen::setText() and setPercentage()

* Feature: New `AbstractTextDialog` base class for question / error / warning / info dialogs
  (#25)
  * Simplified text dialog constructors to accept an optional text argument. This often makes using the `Builder` obsolete.
  
  ```php
  // old
  $builder = new Builder($launcher);
  $builder->info('Hi')->waitReturn();
  
  // new
  $dialog = new InfoDialog('Hi');
  $launcher->waitFor($dialog);
  ```

* Feature: New `ScaleDialog` dialog type
  (#9)

* Improved documentation and vastly improved automated test suite
  (#26)

* Parsing dialog values is now part of the Zen processor
  (#30)

* Internal refactoring, simplify passing args, testability, maintainability
  (#23 and #24)

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
