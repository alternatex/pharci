Phwarch
=============

A PHP development utility to automatically update PHAR archives by watching filesystem changes

Setup
-----

### Platform Support

Tested on Debian, Ubuntu and MacOSX.

### Prerequisites

* PHP (http://php.net)
* Node (http://nodejs.org)
* NPM (https://npmjs.org/)

### Installation

You can install this via the command line with either `curl` or `wget`.

via `curl`

`curl -L https://github.com/alternatex/bazinga/raw/master/install.sh | sh`

via `wget`

`wget --no-check-certificate https://github.com/alternatex/bazinga/raw/master/install.sh -O - | sh`

QuickStart
-------------

###Unix - Inotifywatch

```shell
inotifywait --recursive --monitor --quiet --event modify,create,delete,move --format '%w;%f;%e' "${watch}" |
  while read FILE ; do
    php phwarch.php $FILE "${out}"
  done
```

###/MacOsx - Launchd

#### Configure

~/Library/LaunchAgents/phwarch.plist

```xml
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple Computer//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
    <key>Label</key>
 <string>logger</string>
 <key>ProgramArguments</key>
 <array>
  <string>/usr/bin/logger</string>
  <string>path modified</string>
 </array>
 <key>WatchPaths</key>
 <array>
  <string>/Users/sakra/Desktop/</string>
 </array>
</dict>
</plist>
```

#### Activate

```shell
launchctl load ~/Library/LaunchAgents/phwarch.plist
```

#### Deactivate

```shell
launchctl unload ~/Library/LaunchAgents/phwarch.plist
```

Development
-------------

Ensure php.ini includes `phar.readonly=Off` to enable creation and modification of phar archives using the phar stream or [phar](http://php.net/manual/ru/class.phar.php) object's write support.

```shell
# run
bin/phwarch --xxx=first_opt --yyy=second_opt --zzz=third_opt
```

Roadmap
-------------
- ... *

License
-------------
Released under two licenses: new BSD, and MIT. You may pick the
license that best suits your development needs.

https://raw.github.com/alternatex/phwarch/master/LICENSE

MISC TO REMOVE OR XXX
-------------
shebang > 

#!/bin/phwarch 
.pwarch-files shebang

TODO: 

phwarch as shell script only

» direct script-pass in

just a readme. basta.

create manifest o contents
» md5 hashed
» compare / update phar contents with that?!

hmmm.

- php-class phar-updates / mods XXX
- automated-changes testscript (ini_set('max_execution_time', 0); sleep(XXX);)

chmod a+x src/cli.php