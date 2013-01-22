#!/bin/bash

# system_profiler SPSoftwareDataType

# check growl
use_growlnotifiy=false
if [[ -a "$(which growlnotify)" ]] 
	then
	use_growlnotifiy=true
	growlnotify -m "growlnotify available:$use_growlnotifiy 1" -d test
	growlnotify -m "growlnotify available:$use_growlnotifiy 2" -d test
	growlnotify -m "growlnotify available:$use_growlnotifiy 3" -d test
	growlnotify -m "growlnotify available:$use_growlnotifiy 4" -d test
	growlnotify -m "growlnotify available:$use_growlnotifiy 5" -d test
	growlnotify -m "growlnotify available:$use_growlnotifiy 6" -d test
	growlnotify -m "growlnotify available:$use_growlnotifiy 7" -d test
	growlnotify -m "growlnotify available:$use_growlnotifiy 8" -d test
	growlnotify -m "growlnotify available:$use_growlnotifiy 9" -d test
fi
printf "\e[32mgrowlnotify available:\e[0m $use_growlnotifiy\n"

# check installation
if [[ -a "$(which shinst)" ]]
  then 
	printf "\e[32mshinst found.\e[0m \n"
else
	printf "\e[1;31mshinst not found.\e[0m \n"
	bash -s stable < <(wget https://raw.github.com/alternatex/shinst/master/install.sh -O -)
	exit -1
fi

# check node  
if [[ -a "$(which node)" ]]
  then 
	printf "\e[32mnode found.\e[0m \n"
else
	printf "\e[1;31mnode not found.\e[0m \n"
	exit -1
fi

# check npm
if [[ -a "$(which npm)" ]]
  then 
	printf "\e[32mnpm found.\e[0m \n"
else
	printf "\e[1;31mnpm not found.\e[0m \n"
	exit -1	
fi

# check bazinga
if [[ -a "$(which bazinga)" ]]
  then 
	printf "\e[32mbazinga found.\e[0m \n"
else
	# install dependency
	printf "\e[32minstalling bazinga...\e[0m \n"
	shinst install alternatex/bazinga
	printf "\e[32mdone.\e[0m   $1\n"
fi

# install npm/component dependencies
false && npm install && bower install

# check self
if [[ -a "$(which pharci)" ]]
  then 
	printf "\e[32mpharci installed.\e[0m \n"
else
	printf "\e[1;31mnpharci installation failed.\e[0m \n"
	exit -1
fi