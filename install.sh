#!/bin/bash

# check installation
if [[ -a "$(which shinst)" ]]
  then 
	printf "\e[32mshinst found.\e[0m \n"
else
	printf "\e[1;31mshinst not found.\e[0m \n"
	bash -s stable < <(wget https://raw.github.com/alternatex/shinst/master/install.sh -O -)
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

# check watchdog
if [[ -a "$(which watchmedo)" ]]
  then 
	printf "\e[32mwatchdog/watchmedo found.\e[0m \n"
else

	#install! #post installation script to execute inline
	shinst install gorakhargosh/watchdog -s -

	# go to install dir
	cd ~/.watchdog

	echo "in directory: "
	pwd

    # prerequisites osx
    brew install libyaml

    # prerequisites unix
    false && sudo aptitude install libyaml-dev

	echo "in directory: "
	pwd
	
	# run installer
    sudo python $HOME/.watchdog/setup.py install

    # check installation
	if [[ -a "$(which watchmedo)" ]]
	  then 
	  	printf "\e[32mwatchdog/watchmedo installed.\e[0m \n"
	else
		printf "\e[1;31mwatchdog/watchmedo installation failed.\e[0m \n"
		exit -1	
	fi  

	# go back
	cd -
fi

# check self
if [[ -a ~/.pharci/bin/pharci ]]
  then 
	printf "\e[32mpharci installed.\e[0m \n"
else
	printf "\e[1;31mpharci installation failed.\e[0m \n"
	exit -1
fi