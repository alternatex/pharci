#!/bin/bash

# ...
set +v

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

# start php socket server
./Pharci/socket.php "${pharci_ipaddress}" "${pharci_port}" "${pharci_target}" "${pharci_source}"  "${pharci_output}" &

# store watch pid
socket_pid=$!

# fetch filedescriptor
exec 3<>"/dev/tcp/${pharci_ipaddress}/${pharci_port}"

# start watchdog redirect it's output to socket
watchmedo shell-command \
    --patterns="$pharci_include_pattern" \
    --wait \
    --recursive \
    --command='echo "{ \"watch\": \"${pharci_source}\",\"watch_pid\": \"${pharci_watch_pid}\",\"phar\": \"${pharci_target}\", \"src\": \"${watch_src_path}\", \"dest\": \"${watch_dest_path}\", \"event_type\": \"${watch_event_type}\", \"object\": \"${watch_object}\"}";' "$pharci_source" >&3

# shutdown server
echo "shutdown" >&3

# ensure pid !killed else use gun kill -9 $socket_pid # store watch pid

# *** TODOS ***

# ENSURE PHP PROC KILLED WHEN SCRIPT EXITS

# ENSURE NO PROCESS RUNNING TARGETING SAME OUTFILE

# ON ERROR REBUILD // THINK. HANDLE.

# FINALIZE / CLEANUP WATCH SCRIPT

# TODO check target directory depth and files match pattern » warn if too deep or to many files observe

# IMPLEMENT / USE ALL SETTINGS *
# bazinga_input "ipaddress" "ipaddress"
# bazinga_input "port" "port"
# bazinga_input "output" "output"
# bazinga_input "source" "source" 
# bazinga_input "target" "target"   
# bazinga_input "interval" "interval"   
# bazinga_input "include_pattern" "include_pattern"
# bazinga_input "exclude_pattern" "exclude_pattern" 
# bazinga_input "updates_interval" "updates_interval" 
# bazinga_input "updates_max" "updates_max"   
# bazinga_input "updates_sleep" "updates_sleep" 
# bazinga_input "default_stub" "default_stub" 

