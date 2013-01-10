Phwarch
=============

PHP Development Utility: PHAR Auto-Updater

TODO: 

phwarch as shell script only

» direct script-pass in

just a readme. basta.

create manifest o contents
» md5 hashed

» compare / update phar contents with that?!

hmmm.

- grunt-bower fix » update spreadson aswell * !!!
- php-class phar-updates / mods XXX
- automated-changes testscript (ini_set('max_execution_time', 0); sleep(XXX);)

QuickStart
-------------

###Unix - Inotifywatch###

```shell
inotifywait --recursive --monitor --quiet --event modify,create,delete,move --format '%w;%f;%e' "${watch}" |
  while read FILE ; do
    php -r "echo '${FILE} ${out}';" 
  done
```

###Unix - Inotifywatch###

```shell
inotifywait --recursive --monitor --quiet --event modify,create,delete,move --format '%w;%f;%e' "${watch}" |
  while read FILE ; do
    php phwarch.php $FILE "${out}"
  done
```


###*/MacOsx - Shebang###

chmod a+x src/cli.php

**src/cli.php**

```shell
#!/usr/bin/php
/*!
* ------------------------------------------------------------------               
* Phwarch
*
* PHP Development Utility: PHAR Auto-Updater
*
* Copyright 2013, Gianni Furger <gianni.furger@gmail.com>
* 
* https://raw.github.com/alternatex/phwarch/master/LICENSE
*
* ------------------------------------------------------------------ 
*/
 <?php include('phwarch.php');
```

Phwarch usage example based on [tests](https://github.com/alternatex/phwarch/tests/index.php)

**Configuration**

...

**Validation**

...

[Sample spreadsheet](https://docs.google.com/spreadsheet/pub?key=0ApqLhg-Pef8pdG9DWmRnTzRWdzQ5MHNEdjBYT3RzZnc&single=true&gid=0&output=html)

### Fetch Google Docs Spreadsheet

__See:__ [sources/custom/api/](http://localhost/spreadson/sources/custom/api/)

```php
// include core
require_once('../../../builds/spreadson.core.phar');

// pass-through
Spreadson('spreadsheet://0ApqLhg-Pef8pdG9DWmRnTzRWdzQ5MHNEdjBYT3RzZnc', true, 'Person');
```

Open browser: [http://localhost/spreadson/sources/custom/api/](http://localhost/spreadson/sources/custom/api/)

Installation
-------------

### Prerequisites

#### Core

* PHP (http://php.net)

#### Extensions

**Development**
* Node (http://nodejs.org)
* NPM (https://npmjs.org/)

**Configuration**

### Setup

```shell 
# clone repo
git clone https://github.com/alternatex/phwarch.git && cd phwarch

# node deps
npm install 

# install 
install.sh
```

Development
-------------

Ensure php.ini includes `phar.readonly=Off` to enable creation and modification of phar archives using the phar stream or [phar](http://php.net/manual/ru/class.phar.php) object's write support.

```shell
# run
bin/phwarch -XXX -YYY -ZZZ
```

Roadmap
-------------
- ... *

License
-------------
Released under two licenses: new BSD, and MIT. You may pick the
license that best suits your development needs.

https://github.com/alternatex/phwarch/blob/master/LICENSE
