# tiny-contact
A tiny contact management tool.

tiny-contact ist eine kleine Anwendung aus den tiny-tools um Kontakte zu verwalten.
Als Framework wird bcosca/fatfree-core eingesetzt.
Die Kontakte werden in einer SQLite-Datenbank gespeichert.
Man kann sie mithilfe von jeroendesloovere/vcard auch als vCards herunterladen.
Damit können sie wie die Seiten des TinyWiki mit Git versioniert werden.
Zudem wird monolog für das Logging verwendet.
Anhängigkeiten von Libraries werden mittels Composer gepflegt.

Icons (36px) are from https://icons8.com/icon/free-pack/.

## Links

- Verwendung von F3 mit Composer: https://github.com/F3Community/fatfree-composer-app

## From scratch

    mkdir tiny-contact && cd tiny-contact
    composer.phar require php
    composer.phar require bcosca/fatfree-core
    composer.phar require jeroendesloovere/vcard
    composer.phar require monolog/monolog
    echo "<?php require 'vendor/autoload.php';" > index.php
    echo "Base::instance()->config('config.ini')->run();" >> index.php
    echo "[routes]" > config.ini
    echo "GET /=Controller->index" >> config.ini
    echo "<?php class Controller {public function index($f3) {echo 'Hello world!';}}" > Controller.php

## Dependencies

### Which libraries are used?

    "bcosca/fatfree-core": "^3.6",
    "jeroendesloovere/vcard": "*"
    "monolog/monolog": "^1.23"

bcosca/fatfree-core is the Fat Free Framework.

jeroendesloovere/vcard is a vCard builder and parser.

monolog/monolog is a PSR compatible logger.

## Installation

To install the defined dependencies for the project, just run the install command.

```php composer.phar install```

## Versionierung

Das Projekt ist mittels Git versioniert. Es werden der master und der develop
Branch verwendet. Tags dienen der Definition von Versionen.

## TODO

- search in list
- move index.php and config.ini to app folder
