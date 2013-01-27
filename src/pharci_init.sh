#!/bin/bash

# internals
export PHARCI=~/.pharci
export PHARCI_CWD="`pwd`"
export PHARCI_VERSION='1.0.0'

# require custom
source $BAZINGA_INSTALL_DIR/lib/custom.sh

# wrap
pharci_configure=function(){ bazinga_configure; }

# say hi
printf "\e[1;31m"
echo "
-----------------------------------------
--------- ★  Pharci - v.1.0.0 ★ ---------
-----------------------------------------"
printf "\e[0m"

# preset avail?
if [[ -a "$PHARCI/.bazingac/configure.sh" ]]
  then 
  
  # include configuration
  source $PHARCI/.bazingac/configure.sh
fi

# move back to directory where we started at
cd $PHARCI_CWD

# first execution - clean environment?
if [ ! -d $bazinga_directory ]; then  
  
  # create directory for custom *
  printf "\e[32mcreating new pharci configuration in directory \e[0m$(pwd)\e[32m ...\e[0m\n" 
  mkdir $bazinga_directory
fi

# edit configuration?
if [ -f ".pharcix/settings.sh" ]; then  
  echo "\n configure? («Y» to edit or any key to skip) "
  read -p ""
        ([ "$REPLY" == "y" ] || [ "$REPLY" == "Y" ])  && pharci_configure
else 
  # initialize
  pharci_configure  
fi

# include custom configuration 
source .pharcix/settings.sh && rm -rf .bazingac/settings.sh.tmp && rm -rf .pharcix/settings.sh.tmp