Pharci
=============

PHP development utility to automate replication of files and folders into PHAR-archives by monitoring filesystem modifications using [watchdog](https://github.com/gorakhargosh/watchdog/)

Installation
------------

### Prerequisites

Unix-OS

**Core**
* PHP (http://php.net)
* Python (http://www.python.org)
* Watchdog (https://github.com/gorakhargosh/watchdog)


**Quoting Watchdog/Supported Platforms**
> * Linux 2.6 (inotify)
> * Mac OS X (FSEvents, kqueue)
> * FreeBSD/BSD (kqueue)
> 
> Note that when using watchdog with kqueue, you need the
> number of file descriptors allowed to be opened by programs
> running on your system to be increased to more than the
> number of files that you will be monitoring. The easiest way
> to do that is to edit your ``~/.profile`` file and add
> a line similar to::
> 
>     ulimit -n 1024
> 
> This is an inherent problem with kqueue because it uses
> file descriptors to monitor files. That plus the enormous
> amount of bookkeeping that watchdog needs to do in order
> to monitor file descriptors just makes this a painful way
> to monitor files and directories. In essence, kqueue is
> not a very scalable way to monitor a deeply nested
> directory of files and directories with a large number of
> files.

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
$ pharci

-----------------------------------------
--------- ★  Pharci - v.1.0.0 ★ ---------
-----------------------------------------

configure? («Y» to edit or any key to skip) Y

-----------------------------------------
« script configuration » 
-----------------------------------------

directory: 	.pharcix
current: 	/Users/bazinga/pharci-test
custom: 	.pharcix/settings.sh
temporary: 	.pharcix/settings.sh.tmp

-----------------------------------------
« current configuration » 
-----------------------------------------

export pharci_source="/Users/bazinga/pharci-test";
export pharci_target="/Users/bazinga/Desktop/pharci.phar";
export pharci_include_pattern="*";
export pharci_exclude_pattern="";
export pharci_updates_interval="10000ms";
export pharci_updates_max="100";
export pharci_updates_sleep="20000ms";

-----------------------------------------
« setup new configuration » 
-----------------------------------------

Enter source:
"/Users/bazinga/pharci-test"

Enter target:
"/Users/bazinga/Desktop/pharci.phar"

Enter include_pattern:
"*"

Enter exclude_pattern:
""

Enter updates_interval:
"10000ms"

Enter updates_max:
"10"

Enter updates_sleep:
"20000ms"

-----------------------------------------
« review new configuration » 
-----------------------------------------

export pharci_source="/Users/bazinga/pharci-test";
export pharci_target="/Users/bazinga/Desktop/pharci.phar";
export pharci_include_pattern="*";
export pharci_exclude_pattern="";
export pharci_updates_interval="10000ms";
export pharci_updates_max="10";
export pharci_updates_sleep="20000ms";

-----------------------------------------
« confirm new configuration » 
-----------------------------------------

Press Enter to write changes to disk or ^C to abort

Destination: /Users/bazinga/pharci-test/.pharcix/settings.sh

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