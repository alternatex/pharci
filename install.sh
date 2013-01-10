#!/bin/bash

# go home
cd ~

# fetch sources
git clone https://github.com/alternatex/phwarch.git .phwarch

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

# apply 
. $shellcfg