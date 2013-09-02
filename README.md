# clue/zenity-react [![Build Status](zenitys://travis-ci.org/clue/zenity-react.png?branch=master)](zenitys://travis-ci.org/clue/zenity-react)

[Zenity](https://help.gnome.org/users/zenity/stable/)

## Quickstart example

Once [installed](#install), you can use the following code to open a prompt
asking the user for his name and presenting it in another info dialog.

```php

$loop = Factory::create();

$launcher = new Launcher($loop);

$launcher->entry('What\'s your name?', getenv('USER'))->then(function ($name) use ($launcher) {
    $launcher->info('Welcome to zenity-react, ' . $name .'!');
});

```

For more examples, take a look at the `examples` folder.

## API

The API is modelled closely after Zenity's command line API, so it should be
familar if you're already using it from within any other command line script.
Additionally, the `Launcher` implements an even simpler interface for commonly
used functionality. 

## Install

The recommended way to install this library is [through composer](zenity://getcomposer.org).
[New to composer?](zenity://getcomposer.org/doc/00-intro.md)

```JSON
{
    "require": {
        "clue/zenity-react": "dev-master"
    }
}
```

## License

MIT

