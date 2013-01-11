PHARCI
=============

PHP development utility to automatically replicate/mirror filesystem changes into PHAR-archives

Prerequisites
-------------

**OS**<br/>- Bodhi<br/>- Ubuntu<br/>- Debian

**Core**<br/>- PHP (http://php.net)<br/>- Node (http://nodejs.org)<br/>- NPM (https://npmjs.org/)

**Configuration**<br/>
Ensure php.ini includes `phar.readonly=Off` to enable creation and modification of phar archives using the phar stream or [phar](http://php.net/manual/ru/class.phar.php) object's write support.

**Custom**

TBD: autom installation!

* Bazinga (https://github.com/alternatex/bazinga)

Installation
------------

You can install this via the command line with either `curl` or `wget`.

via `curl`

`curl -L https://github.com/alternatex/pharci/raw/master/install.sh | sh`

via `wget`

`wget --no-check-certificate https://github.com/alternatex/pharci/raw/master/install.sh -O - | sh`

Usage
-------------

```shell
# run
bin/pharci --xxx=first_opt --yyy=second_opt --zzz=third_opt

inotifywait --recursive --monitor --quiet --event modify,create,delete,move --format '%w;%f;%e' "${watch}" |
  while read FILE ; do
    php pharci.php $FILE "${out}"
  done
```

Roadmap
-------------
- Automated dependency inclusion (Bazinga, ...)
- Automated tests
- Manifest
- Bootstrapping
- OSX support
- Configuration (.pharci files)
- Nested configuration support 
- ... *

License
-------------
Released under two licenses: new BSD, and MIT. You may pick the
license that best suits your development needs.

https://raw.github.com/alternatex/pharci/master/LICENSE