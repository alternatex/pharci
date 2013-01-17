#!/bin/bash

# general
PHARCI=~/.pharci

# remember the roots
export currentpath="`pwd`"

# helper - usage (help)
pharci_usage(){
cat << EOF
usage:  pharci <directory> <filename> 

directory:  filesystem path to observer
filename:   phar archive filename 

example: pharci . library.phar

EOF
}

# helper - configure
pharci_configure() {

  # internals
  BAZINGA_HOME="`dirname $1`/.." && cd $BAZINGA_HOME
  BAZINGA_INSTALL="`which bazinga 2>&1`"
  BAZINGA_INSTALL_DIR="`dirname $BAZINGA_INSTALL 2>&1`/.."

  # include core
  source $BAZINGA_INSTALL_DIR/lib/bazinga.sh

  # intialize / gather custom configuration
  bazinga_init $bazinga_namespace

  # shizzl. don't look. todo » solve overwrite data-loss » could be more sexy, right?
  bazinga_custom="${bazinga_custom}.tmp"

  # gather custom configuration
  bazinga_gather

  # replace configurations - write new configuration to disk (actually replacing conf w/ temporary one)
  bazinga_flush

  # dynamic export / convert environment variables as json w/ php-helper
  php $BAZINGA_INSTALL_DIR/mod/json/json.php $bazinga_namespace $bazinga_custom_json
}

# say hi
printf "\e[1;31m"
echo "
------------------------------
--- ★  Pharci - v.1.0.0 ★  ---
------------------------------"
printf "\e[0m"

# include configuration (if any)
source ../.bazingac/configure.sh

# move back to directory where we started at
cd $currentpath

# first execution - clean environment?
if [ ! -d $bazinga_directory ]; then  

  # create custom directory for pharci configuration
  echo "Creating new pharci configuration in directory `pwd`"
  mkdir $bazinga_directory
fi

# edit configuration?
if [ -f ".pharcix/settings.sh" ]; then  
  echo ""
  read -p "Configure? («Y» to edit or any key to skip) "
        ([ "$REPLY" == "y" ] || [ "$REPLY" == "Y" ])  && pharci_configure
else 
  pharci_configure  
fi

# include custom configuration 
source .pharcix/settings.sh && rm -rf .bazingac/settings.sh.tmp && rm -rf .pharcix/settings.sh.tmp

# launch watchdog - TODO: fix path
watchmedo shell-command \
    --patterns="*" \
    --recursive \
    --command='~/Desktop/pharci/src/Pharci/pharci-cli.php "${watch_src_path}" "${watch_dest_path}" "${watch_event_type}" "${watch_object}"' "$1"