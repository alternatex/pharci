#!/bin/bash

# remember the roots
export currentpath="`pwd`"

# helper - print formatted text
function text {
	printf "\e[1;34m"
	echo ""
	echo $1
	printf "\e[0m"
}

# helper - configure
function bazinga_edit() {

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
}

# say hi
printf "\e[1;31m"
echo "
-------------------------------
--- ★  PHARCI - v.1.0.0 ★  ---
-------------------------------"
printf "\e[0m"

# include configuration (if any)
source ../.bazinga/configure.sh

# move back to directory where we started at (TODO: properly solve path issues)
cd $currentpath

# first execution - clean environment?
if [ ! -d $bazinga_directory ]; then	

	# create custom directory for pharci configuration
	echo "Creating new pharci connection in directory `pwd`"
	mkdir $bazinga_directory
fi

# edit configuration?
if [ -f ".pharcix/settings.sh" ]; then	
	echo ""
	read -p "Configure? («Y» to edit or any key to skip)"
        ([ "$REPLY" == "y" ] || [ "$REPLY" == "Y" ])  && bazinga_edit
else 
	bazinga_edit	
fi

# include custom configuration to feed tunnelx 
source .pharcix/settings.sh && rm -rf .pharcix/settings.sh.tmp

# shout out loud
text "listen on:"
echo "127.0.0.1"

text "port:"
echo "$tunnelx_local_port"

text "external host:"
echo "$tunnelx_remote_external_host"

text "internal host:"
echo "$tunnelx_remote_internal_host"

text "internal port:"
echo "$tunnelx_remote_internal_port"

text "identified by user:"
echo "$tunnelx_remote_external_user"

# setup ssh tunnel
printf "\e[1;34m"
echo ""
text "`ssh -N -L $tunnelx_local_port:$tunnelx_remote_internal_host:$tunnelx_remote_internal_port $tunnelx_remote_external_user@$tunnelx_remote_external_host`"
printf "\e[0m"

# configure
watchdir="$pharci_directory"
format='-d "%w" -f "%f" -e "%e"'

# watch directory / dispatch events / exec phar update
inotifywait --recursive --monitor --quiet --event modify,create,delete,move --format "${format}" "${watchdir}" | 
while read FILE ; do    	
	./PHARCI/pharci-cli.php $FILE
done