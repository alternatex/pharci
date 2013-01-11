#!/bin/bash

# prerequisites
echo "bazinga installed? if not - install - shout out loud!"

# curl or wget check ?!

# configuration
targetdir="~/.phwarch"

# go home
cd ~

# fetch sources
git clone https://github.com/alternatex/phwarch.git "${targetdir}" && cd "${targetdir}"

# install node deps
npm install

# install components
bower install

# shell configuration file (TODO: combine with $SHELL environment variable)
shellcfg=""

# BASH
if [ -f ~/.bashrc ]; then 
	shellcfg="$HOME/.bashrc"
fi

# ZSH
if [ -f ~/.zshrc ]; then 
	shellcfg="$HOME/.zshrc"
fi

# ?
if [ -f ~/.profile ]; then 
	shellcfg="$HOME/.profile"
fi

# update shell configuration
echo "# phwarch" >> $shellcfg
echo "export PATH=~/.phwarch/bin:$PATH" >> $shellcfg

# check whether inotifywatch available or OSX if not: cancel install... shout out loud

# store method (inotifywatch/php-loop)

# make executable
chmod a+x "${targetdir}/src/cli.php"

# apply 
. $shellcfg