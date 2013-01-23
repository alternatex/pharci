#!/bin/bash

# ENSURE PHP PROC KILLED WHEN SCRIPT EXITS
# ENSURE NO PROCESS RUNNING TARGETING SAME OUTFILE
# IMPLEMENT / USE ALL SETTINGS *
# ON ERROR REBUILD // THINK. HANDLE.
# FINALIZE / CLEANUP WATCH SCRIPT 

# TODO NEXT:
# REMOVE HC* - almost done » pharci-watch.php to go

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

# shout out loud
printf "\e[32mmonitoring \e[0m'$pharci_source'\e[32m targeting \e[0m'$pharci_target'\e[32m ...\e[0m\n"

# start background process - iterate changes * - optimize approx approach 
false && echo "starting background process" && php "${PHARCI}/src/Pharci/pharci-watch.php" "$pharci_target" &

# store watch pid
export pharci_watch_pid=$! 

# launch watchdog // variant <shell>
watchmedo shell-command \
    --patterns="$pharci_include_pattern" \
    --wait \
    --recursive \
    --command='growlnotify -m "{ \"watch\": \"${pharci_source}\",\"watch_pid\": \"${pharci_watch_pid}\",\"phar\": \"${pharci_target}\", \"src\": \"${watch_src_path}\", \"dest\": \"${watch_dest_path}\", \"event_type\": \"${watch_event_type}\", \"object\": \"${watch_object}\"}" && echo "{ \"watch\": \"${pharci_source}\",\"watch_pid\": \"${pharci_watch_pid}\",\"phar\": \"${pharci_target}\", \"src\": \"${watch_src_path}\", \"dest\": \"${watch_dest_path}\", \"event_type\": \"${watch_event_type}\", \"object\": \"${watch_object}\"}" >> ~/queue.txt' "$pharci_source"