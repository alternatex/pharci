Pharci
=============

PHP development utility to automate replication of files and folders into PHAR-archives by monitoring filesystem modifications using [watchdog](https://github.com/gorakhargosh/watchdog/)

THREAD SAFETY THREAD SAFETY THREAD SAFETY THREAD SAFETY THREAD SAFETY THREAD SAFETY
THREAD SAFETY THREAD SAFETY THREAD SAFETY THREAD SAFETY THREAD SAFETY THREAD SAFETY
THREAD SAFETY THREAD SAFETY THREAD SAFETY THREAD SAFETY THREAD SAFETY THREAD SAFETY
THREAD SAFETY THREAD SAFETY THREAD SAFETY THREAD SAFETY THREAD SAFETY THREAD SAFETY
THREAD SAFETY THREAD SAFETY THREAD SAFETY THREAD SAFETY THREAD SAFETY THREAD SAFETY

RELATIVE SETTINGS RELATIVE SETTINGS RELATIVE SETTINGS RELATIVE SETTINGS RELATIVE SETTINGS 
RELATIVE SETTINGS RELATIVE SETTINGS RELATIVE SETTINGS RELATIVE SETTINGS RELATIVE SETTINGS 
RELATIVE SETTINGS RELATIVE SETTINGS RELATIVE SETTINGS RELATIVE SETTINGS RELATIVE SETTINGS 
RELATIVE SETTINGS RELATIVE SETTINGS RELATIVE SETTINGS RELATIVE SETTINGS RELATIVE SETTINGS 
RELATIVE SETTINGS RELATIVE SETTINGS RELATIVE SETTINGS RELATIVE SETTINGS RELATIVE SETTINGS 

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

Usage
-------------

```shell
pharci <directory> <phar>
```

Roadmap
-------------
- Tests
- Manifest
- Bootstrapping
- Nested configuration support 
- ... *

License
-------------
Released under two licenses: new BSD, and MIT. You may pick the
license that best suits your development needs.

https://raw.github.com/alternatex/pharci/master/LICENSE