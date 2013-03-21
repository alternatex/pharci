Pharci
=============

PHP development utility to automate filesystem to phar replication by monitoring filesystem modifications using [watchdog](https://github.com/gorakhargosh/watchdog)

Installation
------------

### Prerequisites

- MacOSX 10.8 or higher
- PHP (http://php.net)
- Python (http://www.python.org)

### Third-Party Libraries 

The following libraries get installed automatically if prerequisites are met:
- LibYAML (http://pyyaml.org/wiki/LibYAML)
- Watchdog (https://github.com/gorakhargosh/watchdog)

### Setup

You can install this via the command line via:

**[shinst](https://github.com/alternatex/shinst)**

```shell
shinst install alternatex/pharci -s src/tools/install.sh
```

**[composer](http://getcomposer.org)**

```shell
composer require 'alternatex/pharci:*'
```

**[curl](http://curl.haxx.se/)**

```shell
curl https://raw.github.com/alternatex/pharci/master/src/tools/install.sh -o install.sh && bash install.sh
```

**[wget](http://www.gnu.org/software/wget/)**

```shell
wget https://raw.github.com/alternatex/pharci/master/src/tools/install.sh -O install.sh && bash install.sh
```

**or manually ..**

```shell
git clone https://github.com/alternatex/pharci.git ~/.pharci
cd ~/.pharci && src/tools/install.sh
```

### Configuration

Ensure ~/.pharci/src is included in the PATH variable.

### Updates

Release updates must be invoked manually:

```shell
cd ~/.pharci && git pull
```

### Configuration

Ensure php.ini includes `phar.readonly=Off` to enable creation and modification of phar archives using the phar stream or [phar](http://php.net/manual/ru/class.phar.php) object's write support.

Usage
-------------

```shell
$ pharci

# ...

```

Roadmap
-------------
- sexy usage: rebuild by confirmation when batch processing is detected » stack changes - if too much completely rebuilding the archive would make sense > terminal-notifier/notification center

-> on batch detect offer rebuild - on subsequent change detect > clear messages > restart if things are quite again...

- add test per object/event_type (including batch operations)

- timed actions » based on insights gotten from batch operation tests - NO: by use w/ sense just notify glob(pattern) returned count vs recommended/"max"

- ensure all settings used

- add verbose option (todo: statistics impact o echoing » crazy..)

- finalize event handling

- multiple instances (handle ports)

- ensure no multiprocess access on phar
» filenamenize phar » create hash -> .pharci/locks/hash

- compability / remove notifier dependency

- zip & tar/gz streams support

- sign archive \*

- semver

License
-------------
Released under two licenses: new BSD, and MIT. You may pick the
license that best suits your development needs.

https://raw.github.com/alternatex/pharci/master/LICENSE