
[![Waffle.io - Columns and their card count](https://badge.waffle.io/fryntiz/torrentlibre.svg?columns=all)](https://waffle.io/fryntiz/torrentlibre)

# Torrent Libre

TorrentLibre es una aplicación desarrollada por 
[Raúl Caro Pastorino](https://fryntiz.es) como proyecto final de un ciclo 
superior DAW.

Esta aplicación tiene como objetivo compartir torrents para compartir 
material libre o con licencias abiertas indicando la autoría del creador. 

El repositorio para el desarrollo de esta aplicación es 
[https://github.com/fryntiz/torrentlibre](https://github.com/fryntiz/torrentlibre)

DIRECTORY STRUCTURE
-------------------

      ajax/
      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      db/                 contains the structure of the db
      guia/
      helpers/
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      scripts/
      tests/              contains various tests for the basic application
      translations/
      vagrant/
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources
      widgets/


REQUIREMENTS
------------

The minimum requirement by this project that your Web server supports PHP 7.0
.0 and postgresql 9.6.


INSTALLATION
------------

### Install 

~~~
composer install
~~~

Now you should be able to access the application through the following URL,
assuming `torrentlibre` is the directory directly under the Web root.

~~~
http://localhost/torrentlibre/web/
~~~

CONFIGURATION
-------------

### Database

Db directory contents structure for database, you can install this db:

```php
    make dbfull
```

**NOTES:**
The database will be created

To only insert data in a bd already created:

```php
    make db
```

### Application data

Copy the file env.example to .env in the root of the repository and modify 
the values

TESTING
-------

Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework](http://codeception.com/).
By default there are 3 test suites:

- `unit`
- `functional`
- `acceptance`

Tests can be executed by running

```
vendor/bin/codecept run
```

or:

```
make test
```

The command above will execute unit and functional tests. Unit tests are testing the system components, while functional
tests are for testing user interaction. Acceptance tests are disabled by default as they require additional setup since
they perform testing in real browser.

