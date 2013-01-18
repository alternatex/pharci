#!/bin/bash

# internals
export PHARCI=~/.pharci
export PHARCI_CWD="`pwd`"
export PHARCI_VERSION='1.0.0'

# describe usage
pharci_usage(){

  # -h // --help
  cat << EOF
usage:  pharci <path> <file> 

path:   path to observe
file:   phar archive filename 

example: pharci . library.phar

EOF

  # inject version
  echo "version: $PHARCI_VERSION"
}

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
------------------------------
--- ★  Pharci - v.1.0.0 ★  ---
------------------------------"
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
  echo ""
  read -p "configure? («Y» to edit or any key to skip) "
        ([ "$REPLY" == "y" ] || [ "$REPLY" == "Y" ])  && pharci_configure
else 
  # initialize
  pharci_configure  
fi

# include custom configuration 
source .pharcix/settings.sh && rm -rf .bazingac/settings.sh.tmp && rm -rf .pharcix/settings.sh.tmp

#export phar_source="$1"
export phar_source=$( cd `dirname $1` >/dev/null; pwd )
export phar_target="$2"

# ...
printf "\e[32mmonitoring \e[0m'$phar_source'\e[32m targeting \e[0m'$phar_target'\e[32m ...\e[0m\n"

# start background process - iterate changes * - optimize approx approach 
echo "starting background process" && php "${PHARCI}/src/Pharci/pharci-watch.php" &

# launch watchdog
watchmedo shell-command \
  --patterns="*" \
  --recursive \  
  --command='${PHARCI}/src/Pharci/pharci-cli.php "${phar_source}" "${phar_target}" "${watch_src_path}" "${watch_dest_path}" "${watch_event_type}" "${watch_object}"' "$1"

#--command='echo "{ \"watch\": " "\"${phar_source}\"" ",\"phar\":" "\"${phar_target}\"" ",\"src\":" "\"${watch_src_path}\"" ",\"dest\":" "\"${watch_dest_path}\"" ",\"event_type\":" "\"${watch_event_type}\"" ",\"object\":" "\"${watch_object}\"" "}" >> queue.txt' "$1"

  exit

  #!/bin/bash

# internals
export PHARCI=~/.pharci
export PHARCI_CWD="`pwd`"
export PHARCI_VERSION='1.0.0'

# describe usage
pharci_usage(){

  # -h // --help
  cat << EOF
usage:  pharci <path> <file> <timeout> <count>

path:     path to observe
file:     phar archive filename 
timeout:  delay in seconds 
count:    max modifications to track until full update

example: pharci . library.phar

EOF

  # inject version
  echo "version: $PHARCI_VERSION"
}

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
------------------------------
--- ★  Pharci - v.1.0.0 ★  ---
------------------------------"
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
  echo ""
  read -p "configure? («Y» to edit or any key to skip) "
        ([ "$REPLY" == "y" ] || [ "$REPLY" == "Y" ])  && pharci_configure
else 
  # initialize
  pharci_configure  
fi

# include custom configuration 
source .pharcix/settings.sh && rm -rf .bazingac/settings.sh.tmp && rm -rf .pharcix/settings.sh.tmp

#export phar_source="$1"
export phar_source=$( cd `dirname $1` >/dev/null; pwd )
export phar_target="$2" 

# ...
printf "\e[32mmonitoring \e[0m'$phar_source'\e[32m targeting \e[0m'$phar_target'\e[32m ...\e[0m\n"

# start background process - iterate changes * - optimize approx approach 
echo "starting background process" && php "${PHARCI}/src/Pharci/pharci-watch.php" &

# launch watchdog
watchmedo shell-command \
  --patterns="*" \
  --recursive \
  --command='${PHARCI}/src/Pharci/pharci-cli.php "${phar_source}" "${phar_target}" "${watch_src_path}" "${watch_dest_path}" "${watch_event_type}" "${watch_object}"' "$1"
  #--command='echo "{ \"watch\": " "\"${phar_source}\"" ",\"phar\":" "\"${phar_target}\"" ",\"src\":" "\"${watch_src_path}\"" ",\"dest\":" "\"${watch_dest_path}\"" ",\"event_type\":" "\"${watch_event_type}\"" ",\"object\":" "\"${watch_object}\"" "}" >> queue.txt' "$1"
  