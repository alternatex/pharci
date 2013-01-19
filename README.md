Pharci
=============

PHP development utility to automate replication of files and folders into PHAR-archives by monitoring filesystem modifications using [watchdog](https://github.com/gorakhargosh/watchdog/)

Use Case
--------

Simplifies development workflow when working on projects referencing phar archives.

Workflow
--------

Max modifications per time unit until full phar-rebuild:

Error Handling:

- Corrupt-Phar Loop-Count *

Changes within a library included as phar archive.

External resource inclusion flipflop *

Batch prevention *

Directory move/delete > full rebuild *

Installation
------------

### Prerequisites

Unix-OS

**Core**
* PHP (http://php.net)
* Python (http://www.python.org)
* Watchdog (https://github.com/gorakhargosh/watchdog)

### Configuration

Ensure php.ini includes `phar.readonly=Off` to enable creation and modification of phar archives using the phar stream or [phar](http://php.net/manual/ru/class.phar.php) object's write support.

### Setup

You can install this through https://github.com/alternatex/shinst

`shinst install alternatex/pharci`

via `curl`

`bash -s stable < <(curl -s https://raw.github.com/alternatex/pharci/master/install.sh)`

via `wget`

`bash -s stable < <(wget https://raw.github.com/alternatex/pharci/master/install.sh -O -)`

Usage
-------------

```shell
# per directory configuration using bazinga *
pharci
```

Roadmap
-------------
- Tests
- Bootstrapping
- ... *

License
-------------
Released under two licenses: new BSD, and MIT. You may pick the
license that best suits your development needs.

https://raw.github.com/alternatex/pharci/master/LICENSE