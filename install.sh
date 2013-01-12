#!/bin/bash

# prerequisites
echo "bazinga installed? if not - install - shout out loud!"

# curl or wget check ?!
echo "curl or wget check ?!"

# configuration
targetdir="~/.pharci"

# go home
cd ~

# fetch sources
git clone https://github.com/alternatex/pharci.git "${targetdir}" && cd "${targetdir}"

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