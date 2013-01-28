#!/bin/bash

# ...
function check_shinst_pkg(){

	# check shinst pkg
	if [[ -a "$(which $1)" ]]; then 

		# ...	
		printf "\e[32m$1 found\e[0m \n"
	else 
		
		# install dependency
		printf "\e[32minstalling $1...\e[0m \n"

		# install shinst pkg
		shinst install $2
	fi
}

# ...
function check_webinst(){

	# check webinst
	if [[ -a "$(which $1)" ]]; then 

		# ...	
		printf "\e[32m$1 found\e[0m \n"
	else 
		
		# install dependency
		printf "\e[1;31m$1 not found\e[0m \n"

		# fetch/process shinst installer
		bash -s stable < <(wget $2 -O -)
	fi
}

# require shinst
check_webinst "shinst" "https://raw.github.com/alternatex/shinst/master/src/tools/install.sh"

# require shinst packages
check_shinst_pkg "bazinga" "alternatex/bazinga"

# TODO: pharci-notifier » include custom build / fnc wrap

# check terminal notifier
if [[ -a "$(which terminal-notifier)" ]]; then 

	# ...	
	printf "\e[32mterminal-notifier found\e[0m \n"
else 

	# install dependency
	printf "\e[32minstalling terminal-notifier through gem...\e[0m \n"
	
	# ...
	sudo gem install terminal-notifier

    # check installation
	if [[ -a "$(which terminal-notifier)" ]]; then  printf "\e[32mterminal-notifier installed.\e[0m \n";  else printf "\e[1;31malloy/terminal-notifier installation failed.\e[0m \n"; fi 	 
fi

# check watchdog
if [[ -a "$(which watchmedo)" ]]; then 

	# ...
	printf "\e[32mwatchmedo found\e[0m \n" 
else 

	#install! #post installation script to execute inline
	shinst install gorakhargosh/watchdog -s - && cd ~/.watchdog

    # prerequisites osx
    brew install libyaml

	# run installer
    sudo python setup.py install

    # check installation
	if [[ -a "$(which watchmedo)" ]]; then 
	  	printf "\e[32mwatchmedo installed\e[0m \n"
	else
		printf "\e[1;31mwatchmedo installation failed\e[0m \n"
		exit -1	
	fi    		
fi

# check self
if [[ -a "$(which pharci)" ]]; then 
	printf "\e[32mpharci found\e[0m \n"
else
	printf "\e[1;31mpharci installation failed\e[0m \n"
	exit -1
fi