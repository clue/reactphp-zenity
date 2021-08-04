# clue/reactphp-zenity

[![CI status](https://github.com/clue/reactphp-zenity/workflows/CI/badge.svg)](https://github.com/clue/reactphp-zenity/actions)
[![installs on Packagist](https://img.shields.io/packagist/dt/clue/zenity-react?color=blue&label=installs%20on%20Packagist)](https://packagist.org/packages/clue/zenity-react)

Zenity allows you to build graphical desktop (GUI) applications in PHP, built on top of [ReactPHP](https://reactphp.org/).

![https://help.gnome.org/users/zenity/3.24/question.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-question-screenshot.png)

[Zenity](https://help.gnome.org/users/zenity/3.24/) is a small program that
allows creating simple GTK+ dialogs from within command line scripts. Zenity
already ships with Ubuntu-based distributions and does not require any
installation there - so this library should work out of the box. Otherwise you
may have to [install Zenity](#install) yourself. This library provides an easy
to use wrapper to spawn Zenity processes to build graphical desktop applications
with PHP.

**Table of contents**

* [Support us](#support-us)
* [Quickstart example](#quickstart-example)
* [Usage](#usage)
  * [Launcher](#launcher)
    * [setBin()](#setbin)
    * [waitFor()](#waitfor)
    * [launch()](#launch)
    * [launchZen()](#launchzen)
  * [Builder](#builder)
  * [Dialog](#dialog)
    * [AbstractDialog](#abstractdialog)
    * [CalendarDialog](#calendardialog)
    * [ColorSelectionDialog](#colorselectiondialog)
    * [EntryDialog](#entrydialog)
    * [ErrorDialog](#errordialog)
    * [FileSelectionDialog](#fileselectiondialog)
    * [FormsDialog](#formsdialog)
    * [InfoDialog](#infodialog)
    * [ListDialog](#listdialog)
    * [NotificationDialog](#notificationdialog)
    * [PasswordDialog](#passworddialog)
    * [QuestionDialog](#questiondialog)
    * [ScaleDialog](#scaledialog)
    * [TextInfoDialog](#textinfodialog)
    * [WarningDialog](#warningdialog)
* [Install](#install)
* [License](#license)

## Support us

We invest a lot of time developing, maintaining and updating our awesome
open-source projects. You can help us sustain this high-quality of our work by
[becoming a sponsor on GitHub](https://github.com/sponsors/clue). Sponsors get
numerous benefits in return, see our [sponsoring page](https://github.com/sponsors/clue)
for details.

Let's take these projects to the next level together! 🚀

## Quickstart example

Once [installed](#install), you can use the following code to open a prompt
asking the user for his name and presenting it in another info dialog.

```php
$launcher = new Clue\React\Zenity\Launcher();

$entry = new EntryDialog();
$entry->setText('What\'s your name?');
$entry->setEntryText(getenv('USER')); // prefill with current user

$launcher->launch($entry)->then(function ($name) use ($launcher) {
    $launcher->launch(new InfoDialog('Welcome to zenity-react, ' . $name .'!'));
});
```

Looking for more examples? Take a look at the [examples](examples) folder.

## Usage

### Launcher

As shown in the above example, a `Launcher` has to be instantiated once and
is responsible for launching each Zenity dialog. It manages running
the underlying `zenity` process and reports back its state and user interaction.

It uses the [react/event-loop](https://github.com/reactphp/event-loop) component
to enable an async workflow where you can launch multiple dialogs while simultaneously
doing more I/O work. This library exposes both a simple blocking API and a more
advanced async API.

This class takes an optional `LoopInterface|null $loop` parameter that can be used to
pass the event loop instance to use for this object. You can use a `null` value
here in order to use the [default loop](https://github.com/reactphp/event-loop#loop).
This value SHOULD NOT be given unless you're sure you want to explicitly use a
given event loop instance.

```php
$launcher = new Clue\React\Zenity\Launcher();
```

#### setBin()

For launching the process it assumes your `zenity` binary is located in your system `$PATH`.
If it's not, you can explicitly set its path like this:

```php
$launcher->setBin('/some/other/path/zenity');
```

#### waitFor()

The `waitFor($dialog)` method can be used to launch a given dialog and
wait for the Zenity process to return its result.
This simple blocking API allows you to get started quickly without exposing
all nifty async details - and lacking some of its advanced features:

```php
$result = $launcher->waitFor($dialog);
```

#### launch()

The `launch($dialog)` method can be used to asynchronously launch a given dialog
and return a [Promise](https://github.com/reactphp/promise) that will be fulfilled
when the Zenity process returns.
This async API enables you to launch multiple dialogs simultaneously while simultaneously
doing more I/O work.

```php
$launcher->launch($dialog)->then(
    function ($result) {
        // info dialogs complete with a boolean true result
        // text dialogs complete with their respective text
    },
    function ($reason) {
        // dialog was cancelled or there was an error launching the process
    }
});
```

#### launchZen()

The `launchZen($dialog)` method can be used to asynchronously launch a given dialog
and return an instance of the `BaseZen` class.
This instance exposes methods to control the Zenity process while waiting for the results.
Some dialog types also support modifying the information presented to the user.

```php
$zen = $launcher->launchZen($dialog);
Loop::addTimer(3.0, function () use ($zen) {
    $zen->close();
});

$zen->promise()->then(function ($result) {
    // dialog completed
});
```

### Builder

Additionally, the `Builder` implements an even simpler interface for commonly
used dialogs. This is mostly for convenience, so you can get started easier.
The methods should be fairly self-explanatory and map directly to the Zenity 
dialogs listed below.

```php
$builder = new Builder();
$dialog = $builder->info('Hello world');
```

For anything more complex, you can also instantiate the below classes directly.

### Dialog

The `Dialog` API is modelled closely after Zenity's command line API, so it should be
familar if you're already using it from within any other command line script.

#### AbstractDialog

Abstract base class for all Zenity dialogs (see below for details on each concrete type).

#### CalendarDialog

![https://help.gnome.org/users/zenity/3.24/calendar.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-calendar-screenshot.png)

#### ColorSelectionDialog

![https://help.gnome.org/users/zenity/3.24/colorselection.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-colorselection-screenshot.png)

#### EntryDialog

```php
$builder->entry($prompt = null, $prefill = null);
```

![https://help.gnome.org/users/zenity/3.24/entry.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-entry-screenshot.png)

#### ErrorDialog

```php
$builder->error($text, $title = null);
```

![https://help.gnome.org/users/zenity/3.24/error.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-error-screenshot.png)

#### FileSelectionDialog

```php
$builder->fileSelection($title = null, $multiple = false);
$builder->fileSave($title = null, $previous = null);
$builder->directorySelection($title = null, $multiple = false);
```

![https://help.gnome.org/users/zenity/3.24/fileselection.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-fileselection-screenshot.png)

#### FormsDialog

![https://help.gnome.org/users/zenity/3.24/forms.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-forms-screenshot.png)

#### InfoDialog

```php
$builder->info($text, $title = null);
```

![https://help.gnome.org/users/zenity/3.24/info.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-information-screenshot.png)

#### ListDialog

```php
$builder->listCheck(array $list, $text = null, array $selected = null);
$builder->listMenu(array $list, $text = null);
$builder->listRadio(array $list, $text = null, $selected = null);
$builder->table(array $rows, array $columns = null, $text = null);
```

Where `$selected` in case of listCheck is an array of keys of the items from `$list` you want to preselect.
Where `$selected` in case of listRadio is the key of the item from `$list` you want to preselect.

![https://help.gnome.org/users/zenity/3.24/list.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-list-screenshot.png)

#### NotificationDialog

```php
$builder->notification($text);
$builder->notifier();
```

![https://help.gnome.org/users/zenity/3.24/notification.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-notification-screenshot.png)

#### PasswordDialog

![https://help.gnome.org/users/zenity/3.24/password.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-password-screenshot.png)

#### ProgressDialog

```php
$builder->progress($text = null);
$builder->pulsate($text = null);
```

![https://help.gnome.org/users/zenity/3.24/progress.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-progress-screenshot.png)

#### QuestionDialog

```php
$builder->question($question, $title = null);
```

![https://help.gnome.org/users/zenity/3.24/question.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-question-screenshot.png)

#### ScaleDialog

![https://help.gnome.org/users/zenity/3.24/scale.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-scale-screenshot.png)

#### TextInfoDialog

```php
$builder->text($filename, $title = null);
$builder->editable($filename, $title = null);
$builder->confirmLicense($filename, $confirmation, $title = null);
```

![https://help.gnome.org/users/zenity/3.24/text.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-text-screenshot.png)

#### WarningDialog

```php
$builder->warning($text, $title = null);
```

![https://help.gnome.org/users/zenity/3.24/warning.html](https://help.gnome.org/users/zenity/3.24/figures/zenity-warning-screenshot.png)

## Install

The recommended way to install this library is [through Composer](https://getcomposer.org).
[New to Composer?](https://getcomposer.org/doc/00-intro.md)

This will install the latest supported version:

```bash
$ composer require clue/zenity-react:^0.4.4
```

See also the [CHANGELOG](CHANGELOG.md) for details about version upgrades.

This project aims to run on any platform and thus does not require any PHP
extensions and supports running on legacy PHP 5.3 through current PHP 8+ and
HHVM.
It's *highly recommended to use PHP 7+* for this project.

Obviously, this library requires the Zenity binary itself.
Zenity already ships with Ubuntu-based distributions and should not require any installation there.
On Debian- and Ubuntu-based distributions you can make sure it's installed like this:

```bash
# usually not required
$ sudo apt-get install zenity
```

Otherwise you may have to install Zenity yourself (use your favorite search engine, download the appropriate realease tarball or compile from soure).
Zenity it not officially supported on other platforms, however several non-official releases exist.

*Running on [Windows is currently not supported](https://github.com/reactphp/child-process/issues/9)*

This library assumes Zenity is installed in your PATH. If it is not, you can explicitly set its path like this:

```php
$launcher = new Clue\React\Zenity\Launcher();
$launcher->setBin('/path/to/zenity');
```

## Tests

To run the test suite, you first need to clone this repo and then install all
dependencies [through Composer](https://getcomposer.org):

```bash
$ composer install
```

To run the test suite, go to the project root and run:

```bash
$ php vendor/bin/phpunit
```

## License

This project is released under the permissive [MIT license](LICENSE).

> Did you know that I offer custom development services and issuing invoices for
  sponsorships of releases and for contributions? Contact me (@clue) for details.
