# clue/zenity-react [![Build Status](https://travis-ci.org/clue/php-zenity-react.svg?branch=master)](https://travis-ci.org/clue/php-zenity-react)

[Zenity](https://help.gnome.org/users/zenity/stable/) is a small program that allows
creating simple GTK+ dialogs from within command line scripts. This library provides
an easy to use wrapper to spawn zenity processes to build graphical desktop applications
with PHP.

Zenity already ships with Ubuntu-based distributions and does not require any installation
there - so this library should work out of the box. Otherwise you may have to install
zenity yourself.

## Quickstart example

Once [installed](#install), you can use the following code to open a prompt
asking the user for his name and presenting it in another info dialog.

```php
$loop = Factory::create();
$launcher = new Launcher($loop);

$entry = new EntryDialog();
$entry->setText('What\'s your name?');
$entry->setEntryText(getenv('USER')); // prefill with current user

$launcher->launch($entry)->then(function ($name) use ($launcher) {
    $launcher->launch(new InfoDialog('Welcome to zenity-react, ' . $name .'!'));
});

$loop->run();
```

Looking for more examples? Take a look at the [examples](examples) folder.

## Usage

### Launcher

As shown in the above example, a `Launcher` has to be instantiated once and
is responsible for launching each zenity dialog. It manages running
the underlying `zenity` process and reports back its state and user interaction.

It uses the [react/event-loop](https://github.com/reactphp/event-loop) component
to enable an async workflow where you can launch multiple dialogs while simultaneously
doing more I/O work. This library exposes both a simple blocking API and a more
advanced async API.

```php
$loop = React\EventLoop\Factory::create();
$launcher = new Launcher($loop);
```

#### setBin()

For launching the process it assumes your `zenity` binary is located in your system `$PATH`.
If it's not, you can explicitly set its path like this:

```php
$launcher->setBin('/some/other/path/zenity');
```

#### waitFor()

The `waitFor($dialog)` method can be used to launch a given dialog and
wait for the zenity process to return its result.
This simple blocking API allows you to get started quickly without exposing
all nifty async details - and lacking some of its advanced features:

```php
$result = $launcher->waitFor($dialog);
```

#### launch()

The `launch($dialog)` method can be used to asynchronously launch a given dialog
and return a [Promise](https://github.com/reactphp/promise) that will be fulfilled
when the zenity process returns.
This async API enables you to launch multiple dialogs simultaneously while simultaneously
doing more I/O work.

```php
$launcher->launch($dialog)->then(
    function ($result) {
        // info dialogs complete with a boolean true result
        // text dialogs complete with their respective text
    },
    function ($reason) {
        // dialog was cancelled or their was an error launching the process
    }
});
```

The launched zenity process exposes methods to control the process while waiting for the results.
Some dialog types also support modifying the information presented to the user.

```php
$zen = $launcher->launch($dialog);
$loop->addTimer(3.0, function () use ($zen) {
    $zen->close();
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

Abstract base class for all zenity dialogs (see below for details on each concrete type).

#### CalendarDialog

![https://help.gnome.org/users/zenity/stable/calendar.html](https://help.gnome.org/users/zenity/stable/figures/zenity-calendar-screenshot.png)

#### ColorSelectionDialog

![https://help.gnome.org/users/zenity/stable/colorselection.html](https://help.gnome.org/users/zenity/stable/figures/zenity-colorselection-screenshot.png)

#### EntryDialog

```php
$builder->entry($prompt = null, $prefill = null);
```

![https://help.gnome.org/users/zenity/stable/entry.html](https://help.gnome.org/users/zenity/stable/figures/zenity-entry-screenshot.png)

#### ErrorDialog

```php
$builder->error($text, $title = null);
```

![https://help.gnome.org/users/zenity/stable/error.html](https://help.gnome.org/users/zenity/stable/figures/zenity-error-screenshot.png)

#### FileSelectionDialog

```php
$builder->fileSelection($title = null, $multiple = false);
$builder->fileSave($title = null, $previous = null);
$builder->directorySelection($title = null, $multiple = false);
```

![https://help.gnome.org/users/zenity/stable/fileselection.html](https://help.gnome.org/users/zenity/stable/figures/zenity-fileselection-screenshot.png)

#### FormsDialog

![https://help.gnome.org/users/zenity/stable/forms.html](https://help.gnome.org/users/zenity/stable/figures/zenity-forms-screenshot.png)

#### InfoDialog

```php
$builder->info($text, $title = null);
```

![https://help.gnome.org/users/zenity/stable/info.html](https://help.gnome.org/users/zenity/stable/figures/zenity-information-screenshot.png)

#### ListDialog

```php
$builder->listCheck(array $list, $text = null, $selected = null);
$builder->listMenu(array $list, $text = null);
$builder->listRadio(array $list, $text = null, array $selected = null);
$builder->table(array $rows, array $columns = null, $text = null);
```

![https://help.gnome.org/users/zenity/stable/list.html](https://help.gnome.org/users/zenity/stable/figures/zenity-list-screenshot.png)

#### NotificationDialog

```php
$builder->notification($text);
$builder->notifier();
```

![https://help.gnome.org/users/zenity/stable/notification.html](https://help.gnome.org/users/zenity/stable/figures/zenity-notification-screenshot.png)

#### PasswordDialog

![https://help.gnome.org/users/zenity/stable/password.html](https://help.gnome.org/users/zenity/stable/figures/zenity-password-screenshot.png)

#### ProgressDialog

```php
$builder->progress($text = null);
$builder->pulsate($text = null);
```

![https://help.gnome.org/users/zenity/stable/progress.html](https://help.gnome.org/users/zenity/stable/figures/zenity-progress-screenshot.png)

#### QuestionDialog

```php
$builder->question($question, $title = null);
```

![https://help.gnome.org/users/zenity/stable/question.html](https://help.gnome.org/users/zenity/stable/figures/zenity-question-screenshot.png)

#### ScaleDialog

![https://help.gnome.org/users/zenity/stable/scale.html](https://help.gnome.org/users/zenity/stable/figures/zenity-scale-screenshot.png)

#### TextInfoDialog

```php
$builder->text($filename, $title = null);
$builder->editable($filename, $title = null);
$builder->confirmLicense($filename, $confirmation, $title = null);
```

![https://help.gnome.org/users/zenity/stable/text.html](https://help.gnome.org/users/zenity/stable/figures/zenity-text-screenshot.png)

#### WarningDialog

```php
$builder->warning($text, $title = null);
```

![https://help.gnome.org/users/zenity/stable/warning.html](https://help.gnome.org/users/zenity/stable/figures/zenity-warning-screenshot.png)

## Install

The recommended way to install this library is [through composer](https://getcomposer.org).
[New to composer?](https://getcomposer.org/doc/00-intro.md)

```JSON
{
    "require": {
        "clue/zenity-react": "~0.3.0"
    }
}
```

Obviously, this library requires the Zenity binary itself.
Zenity already ships with Ubuntu-based distributions and should not require any installation there.
On Debian- and Ubuntu-based distributions you can make sure it's installed like this:

```bash
# usually not required
$ sudo apt-get install zenity
```

Otherwise you may have to install Zenity yourself (use your favorite search engine, download the appropriate realease tarball or compile from soure).
Zenity it not officially supported on other platforms, however several non-official releases exist.

This library assumes Zenity is installed in your PATH. If it is not, you can explicitly set its path like this:

```php
$launcher = new Launcher($loop);
$launcher->setBin('/path/to/zenity');
```

## License

MIT

