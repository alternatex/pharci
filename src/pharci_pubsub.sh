#!/bin/bash

# shout out loud
printf "\e[32mmonitoring \e[0m'$pharci_source'\e[32m targeting \e[0m'$pharci_target'\e[32m ...\e[0m\n"

# start background process - iterate changes * - optimize approx approach 
false && echo "starting background process" && php "${PHARCI}/src/Pharci/pharci-watch.php" "$pharci_target" &

# store watch pid (TODO impl differently - multiple instances should be possible...)
export pharci_watch_pid=$! 