Pharci
=============

PHP development utility to automate replication of files and folders into PHAR-archives by monitoring filesystem modifications

Setup
-----

### Prerequisites

Unix-OS [Bodhi, Ubuntu and Debian]

**Core**
* PHP (http://php.net)
* Node (http://nodejs.org)
* NPM (https://npmjs.org/)
* Bazinga (https://github.com/alternatex/bazinga)

### Configuration

Ensure php.ini includes `phar.readonly=Off` to enable creation and modification of phar archives using the phar stream or [phar](http://php.net/manual/ru/class.phar.php) object's write support.

### Installation

You can install this via the command line with either `curl` or `wget`.

via `curl`

`curl -L https://github.com/alternatex/pharci/raw/master/install.sh | sh`

via `wget`

`wget --no-check-certificate https://github.com/alternatex/pharci/raw/master/install.sh -O - | sh`

Usage
-------------

### \*nix

```shell
pharci --xxx=first_opt --yyy=second_opt --zzz=third_opt
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