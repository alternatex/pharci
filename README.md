Pharci
=============

PHP development utility to automate filesystem > phar replication by monitoring filesystem modifications using [watchdog](https://github.com/gorakhargosh/watchdog/)

Installation
------------

### Prerequisites

- MacOSX (TODO: add switches - only terminal-notifier blocks other Unix OS's)
- PHP (http://php.net)
- Python (http://www.python.org)

**Automatic installers:**
- Watchdog (https://github.com/gorakhargosh/watchdog)
- Terminal-Notifier 

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
- sexy usage: rebuild by confirmation when batch processing is detected » stack changes - if too much completely rebuilding the archive would make sense > terminal-notifier/notification center
-> on batch detect offer rebuild - on subsequent change detect > clear messages > restart if things are quite again...
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