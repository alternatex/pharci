  #!/bin/bash

# ENSURE PHP PROC KILLED WHEN SCRIPT EXITS
# ENSURE NO PROCESS RUNNING TARGETING SAME OUTFILE
# IMPLEMENT / USE ALL SETTINGS *
# ON ERROR REBUILD // THINK. HANDLE.
# DIFFERENT / BETTER PERFORMING APPROACH TO ACCESS PHAR > KEEP WITHIN LOOP MEM; TMP EXTRACT?!
# ADD GROWL MESSAGES?
# FINALIZE / CLEANUP WATCH SCRIPT 
# REMOVE HC*

set +v

# internals
export PHARCI=~/.pharci
export PHARCI_CWD="`pwd`"
export PHARCI_VERSION='1.0.0'

# configure
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
-----------------------------------------
--------- ★  Pharci - v.1.0.0 ★ ---------
-----------------------------------------"
printf "\e[0m"

# include configuration (if any)
source $PHARCI/.bazingac/configure.sh

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
true && echo "starting background process" && php "${PHARCI}/src/Pharci/pharci-watch.php" "$pharci_target" &

# store watch pid (TODO: is this really the way to determine a forked child process (is it?!))
export pharci_watch_pid=$! 

# <make watch>
#watch make
#watch make clean once in a while?

# launch watchdog // variant <php>
watchmedo shell-command \
    --patterns="$pharci_include_pattern" \
    --wait \
    --recursive \
    --command='growlnotify -m "{ \"watch\": \"${pharci_source}\",\"watch_pid\": \"${pharci_watch_pid}\",\"phar\": \"${pharci_target}\", \"src\": \"${watch_src_path}\", \"dest\": \"${watch_dest_path}\", \"event_type\": \"${watch_event_type}\", \"object\": \"${watch_object}\"}" && echo "{ \"watch\": \"${pharci_source}\",\"watch_pid\": \"${pharci_watch_pid}\",\"phar\": \"${pharci_target}\", \"src\": \"${watch_src_path}\", \"dest\": \"${watch_dest_path}\", \"event_type\": \"${watch_event_type}\", \"object\": \"${watch_object}\"}" >> ~/queue.txt' "$pharci_source"

#    --interval=$pharci_interval \
#    --wait \    
#    --command='${PHARCI}/src/Pharci/pharci-cli.php "${pharci_watch_pid} " "${pharci_source}" "${pharci_include_pattern}" "${pharci_target}" "${watch_src_path}" "${watch_dest_path}" "${watch_event_type}" "${watch_object}"' "$pharci_source"

# TODO: termination helper? os-solved? check. think.