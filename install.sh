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