Pharci
=============

PHP development utility to automate filesystem > phar replication by monitoring filesystem modifications using [watchdog](https://github.com/gorakhargosh/watchdog/)

watchdog approach

watch/make approach

Installation
------------

### Prerequisites

* Unix OS
* PHP (http://php.net)
* Python (http://www.python.org)

* Watchdog (https://github.com/gorakhargosh/watchdog)

or

* Watch (https://github.com/visionmedia/watch)
* Make (http://www.gnu.org/software/make)

### Optional

* Growl (http://growl.info)

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

Settings/Runtime/Project configuration
--------------------------------------
...

Usage
-------------

```shell
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

### Growl (Optional)

Tested with sources tagged[Growl.app 2.0.1](http://code.google.com/p/growl/source/list?name=Growl.app+2.0.1)

#### Build from source

##### Growl.app
export LC_ALL="en_US.UTF-8"
hg clone https://code.google.com/p/growl/
false && hg tags | sort
hg update "Growl.app 2.0.1"

Keychain Access.app:
Keychain Access.app -> application's name menu -> certificate assistant -> create a certificate: 

'3rd Party Mac Developer Application: The Growl Project, LLC' 
'3rd Party Mac Developer Application'
'Mac Developer'

(or whatever it complains about ...\*)

When doing a rebuild after a complaint about the certificate be sure to clean before running the build again. In extremis; restart xcode.

More infos can be found [here](http://growl.info/documentation/developer/growl-source-install.php), [here](http://code.google.com/p/growl/) and [here](http://growl.info/extras.php#growlnotify)

##### GrowlNotify
Project can be found under Extras/. Build and copy resulting product to /usr/local/bin and ensure this directory is contained in your PATH variable.

```
Usage: growlnotify [-hsvuwc] [-i ext] [-I filepath] [--image filepath]
                               [-a appname] [-p priority] [-H host] [-P password]
                               [--port port] [-n name] [-A method] [--progress value]
                               [--html] [-m message] [-t] [title]
            Options:
                -h,--help       Display this help
                -v,--version    Display version number
                -n,--name       Set the name of the application that sends the notification
                                [Default: growlnotify]
                -s,--sticky     Make the notification sticky
                -a,--appIcon    Specify an application name to take the icon from
                -i,--icon       Specify a file type or extension to look up for the notification icon
                -I,--iconpath   Specify a file whose icon will be the notification icon
                   --image      Specify an image file to be used for the notification icon
                -m,--message    Sets the message to be used instead of using stdin
                                Passing - as the argument means read from stdin
                -p,--priority   Specify an int or named key (default is 0)
                -d,--identifier Specify a notification identifier (used for coalescing)
                -H,--host       Specify a hostname to which to send a remote notification.
                -P,--password   Password used for remote notifications.
                -u,--udp        Use UDP instead of DO to send a remote notification.
                   --port       Port number for UDP notifications.
                -A,--auth       Specify digest algorithm for UDP authentication.
                                Either MD5 [Default], SHA256 or NONE.
                -c,--crypt      Encrypt UDP notifications.
                -w,--wait       Wait until the notification has been dismissed.
                   --progress   Set a progress value for this notification.
            
            Display a notification using the title given on the command-line and the
            message given in the standard input.
            
            Priority can be one of the following named keys: Very Low, Moderate, Normal,
            High, Emergency. It can also be an int between -2 and 2.
            
            To be compatible with gNotify the following switch is accepted:
                -t,--title      Does nothing. Any text following will be treated as the
                                title because that's the default argument behaviour
```

man growlnotify

**Tested on:**
System Version: OS X 10.8.1 (12B19)
Kernel Version: Darwin 12.1.0

Enable Growl in configuration:
pharci > edit settings:
Enable Growl Notifcations?: true (any other value will be intrepreted as false)

License
-------------
Released under two licenses: new BSD, and MIT. You may pick the
license that best suits your development needs.

https://raw.github.com/alternatex/pharci/master/LICENSE