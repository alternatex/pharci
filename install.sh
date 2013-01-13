#!/bin/bash

curl -L https://github.com/alternatex/bazinga/raw/master/install.sh | sh
wget --no-check-certificate https://github.com/alternatex/bazinga/raw/master/install.sh -O - | sh

        if command -v "curl2" &>/dev/null
        then
                echo " Yes, command :curl: was found."
        elif command -v "wget2" &>/dev/null
        then 
                echo " Yes, command :wget: was NOT found."
        else
        	    echo "NONE FOUND."
        fi

echo "neddddd"
function exists() {
        if command -v $1 &>/dev/null
        then
                echo " Yes, command :$1: was found."
                return 1
        else
                echo " No, command :$1: was NOT found."
                return 0
        fi
}

exists bazinga
echo " and the exit status is :$?:"

echo
exists lsss
echo " and the exit status is :$?:"

# prerequisites
echo "bazinga installed? if not - install - shout out loud!"

# curl or wget check ?!
echo "curl or wget check ?!"

# configuration
targetdir="~/.pharci"

# go home
#cd ~

# fetch sources
#git clone https://github.com/alternatex/pharci.git "${targetdir}" && cd "${targetdir}"

# install node deps
npm install

# install components
bower install

# shell configuration file (TODO: combine with $SHELL environment variable)
shellcfg=""

# bash
if [ -f ~/.bashrc ]; then 
	shellcfg="$HOME/.bashrc"
fi

# zsh
if [ -f ~/.zshrc ]; then 
	shellcfg="$HOME/.zshrc"
fi

# ?
if [ -f ~/.profile ]; then 
	shellcfg="$HOME/.profile"
fi

# update shell configuration
echo "# pharci" >> $shellcfg
echo "export PATH=~/.pharci/bin:$PATH" >> $shellcfg

# check whether inotifywatch available or OSX if not: cancel install... shout out loud
echo "prerequisites check - inotify?"
echo "prerequisites check - macosx?"
echo "store method (inotifywatch/php-loop)"

# make executable
chmod a+x "${targetdir}/src/pharci-cli.php"

# apply 
. $shellcfg