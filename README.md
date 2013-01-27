Pharci
=============

PHP development utility to automate filesystem > phar replication by monitoring filesystem modifications using [watchdog](https://github.com/gorakhargosh/watchdog/)

Installation
------------

### Prerequisites

* Unix OS
* PHP (http://php.net)
* Python (http://www.python.org)
* Watchdog (https://github.com/gorakhargosh/watchdog)

### Configuration

Ensure php.ini includes `phar.readonly=Off` to enable creation and modification of phar archives using the phar stream or [phar](http://php.net/manual/ru/class.phar.php) object's write support.

### Setup

You can install this through https://github.com/alternatex/shinst

`shinst install alternatex/pharci`

via `curl`

`bash -s master < <(curl -s https://raw.github.com/alternatex/pharci/master/install.sh)`

via `wget`

`bash -s master < <(wget https://raw.github.com/alternatex/pharci/master/install.sh -O -)`

Usage
-------------

```shell
$ pharci

<todo::insert::dialog::here>
<todo::insert::dialog::here>
<todo::insert::dialog::here>
<todo::insert::dialog::here>
<todo::insert::dialog::here>
<todo::insert::dialog::here>

```

Roadmap
-------------
- add test per object/event_type (including batch operations)
- timed actions » based on insights gotten from batch operation tests
- ensure all settings used
- add verbose option (todo: statistics impact o echoing)
- max directory depth / files to monitor
- finalize event handling
- multiple instances (handle ports)
- ensure no multiprocess access on phar
- zip & tar/gz streams support
- semver

License
-------------
Released under two licenses: new BSD, and MIT. You may pick the
license that best suits your development needs.

https://raw.github.com/alternatex/pharci/master/LICENSE