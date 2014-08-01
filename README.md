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
$builder = new Builder($launcher);

$builder->entry('What\'s your name?', getenv('USER'))->then(function ($name) use ($builder) {
    $builder->info('Welcome to zenity-react, ' . $name .'!')->run();
});

```

For more examples, take a look at the `example` folder.

## API

The API is modelled closely after Zenity's command line API, so it should be
familar if you're already using it from within any other command line script.

### Launcher

As shown in the above example, a `Launcher` has to be instantiated once and
will be passed as a dependency to each `Zenity` dialog. It manages running
the underlying `zenity` process and its dependencies.

Therefor it assumes your `zenity` binary is located in your system `$PATH`.
If it's not, you can explicitly set its path via
```php
$launcher->setBin('/some/other/path/zenity');
```

### Builder

Additionally, the `Builder` implements an even simpler interface for commonly
used dialogs. This is mostly for convenience, so you can get started easier.
The methods should be fairly self-explanatory and map directly to the Zenity 
dialogs listed below.

For anything more complex, you can also instantiate the below classes directly.

### AbstractDialog

Abstract base class for all zenity dialogs (see below for details on each concrete type).

### CalendarDialog

![https://help.gnome.org/users/zenity/stable/calendar.html](https://help.gnome.org/users/zenity/stable/figures/zenity-calendar-screenshot.png)

### ColorSelectionDialog

![https://help.gnome.org/users/zenity/stable/colorselection.html](https://help.gnome.org/users/zenity/stable/figures/zenity-colorselection-screenshot.png)

### EntryDialog

```php
$builder->entry($prompt = null, $prefill = null);
```

![https://help.gnome.org/users/zenity/stable/entry.html](https://help.gnome.org/users/zenity/stable/figures/zenity-entry-screenshot.png)

### ErrorDialog

```php
$builder->error($text, $title = null);
```

![https://help.gnome.org/users/zenity/stable/error.html](https://help.gnome.org/users/zenity/stable/figures/zenity-error-screenshot.png)

### FileSelectionDialog

```php
$builder->fileSelection($title = null, $multiple = false);
$builder->fileSave($title = null, $previous = null);
$builder->directorySelection($title = null, $multiple = false);
```

![https://help.gnome.org/users/zenity/stable/fileselection.html](https://help.gnome.org/users/zenity/stable/figures/zenity-fileselection-screenshot.png)

### FormsDialog

![https://help.gnome.org/users/zenity/stable/forms.html](https://help.gnome.org/users/zenity/stable/figures/zenity-forms-screenshot.png)

### InfoDialog

```php
$builder->info($text, $title = null);
```

![https://help.gnome.org/users/zenity/stable/info.html](https://help.gnome.org/users/zenity/stable/figures/zenity-information-screenshot.png)

### ListDialog

```php
$builder->listCheck(array $list, $text = null, $selected = null);
$builder->listMenu(array $list, $text = null);
$builder->listRadio(array $list, $text = null, array $selected = null);
$builder->table(array $rows, array $columns = null, $text = null);
```

The name "list" is a reserved keyword in PHP, hence we had to use the name `ListDialog` instead.

![https://help.gnome.org/users/zenity/stable/list.html](https://help.gnome.org/users/zenity/stable/figures/zenity-list-screenshot.png)

### NotificationDialog

```php
$builder->notification($text, $icon = null);
$builder->notifier();
```

![https://help.gnome.org/users/zenity/stable/notification.html](https://help.gnome.org/users/zenity/stable/figures/zenity-notification-screenshot.png)

### PasswordDialog

![https://help.gnome.org/users/zenity/stable/password.html](https://help.gnome.org/users/zenity/stable/figures/zenity-password-screenshot.png)

### ProgressDialog

```php
$builder->progress($text = null);
$builder->pulsate($text = null);
```

![https://help.gnome.org/users/zenity/stable/progress.html](https://help.gnome.org/users/zenity/stable/figures/zenity-progress-screenshot.png)

### QuestionDialog

```php
$builder->question($question, $title = null);
```

![https://help.gnome.org/users/zenity/stable/question.html](https://help.gnome.org/users/zenity/stable/figures/zenity-question-screenshot.png)

### Scale

![https://help.gnome.org/users/zenity/stable/scale.html](https://help.gnome.org/users/zenity/stable/figures/zenity-scale-screenshot.png)

### TextInfoDialog

```php
$builder->text($filename, $title = null);
$builder->editable($filename, $title = null);
$builder->confirmLicense($filename, $confirmation, $title = null);
```

![https://help.gnome.org/users/zenity/stable/text.html](https://help.gnome.org/users/zenity/stable/figures/zenity-text-screenshot.png)

### WarningDialog

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
        "clue/zenity-react": "~0.2.0"
    }
}
```

## License

MIT

