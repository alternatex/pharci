Pharci
=============

PHP development utility to automate filesystem > phar replication by monitoring filesystem modifications using [watchdog](https://github.com/gorakhargosh/watchdog/)

Installation
------------

### Prerequisites

* Unix OS

* Bash (>=4.0)

* PHP (http://php.net)
* Python (http://www.python.org)
* Watchdog (https://github.com/gorakhargosh/watchdog)

Auto-Installation?!
Auto-Installation?!
Auto-Installation?!
Auto-Installation?!
Auto-Installation?!
Auto-Installation?!
Auto-Installation?!

» custom prefix »»» check docs and apply
* Redis (http://redis.io)

Dependency: predis » 

### Configuration

Ensure php.ini includes `phar.readonly=Off` to enable creation and modification of phar archives using the phar stream or [phar](http://php.net/manual/ru/class.phar.php) object's write support.

### Setup

You can install this through https://github.com/alternatex/shinst

`shinst install alternatex/pharci`

via `curl`

`bash -s stable < <(curl -s https://raw.github.com/alternatex/pharci/master/install.sh)`

via `wget`

`bash -s stable < <(wget https://raw.github.com/alternatex/pharci/master/install.sh -O -)`

### Platform Notes

*Quoting Watchdog/Supported Platforms*:

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

Usage
-------------

```shell
$ pharci
```

License
-------------
Released under two licenses: new BSD, and MIT. You may pick the
license that best suits your development needs.

https://raw.github.com/alternatex/pharci/master/LICENSE