#!/bin/bash

# check installation
if [[ -a "$(which shinst)" ]]
  then 
  
	# shout out loud
	printf "\e[32mshinst found.\e[0m   $1\n"
else
	# shout out loud
	printf "\e[1;31mshinst not found.\e[0m   $1\n"
	
	# ...
	bash -s stable < <(wget https://raw.github.com/alternatex/shinst/master/install.sh -O -)
	#exit 101
fi

# check node  
if [[ -a "$(which node)" ]]
  then 
  
	# shout out loud
	printf "\e[32mnode found.\e[0m   $1\n"
else
	# shout out loud
	printf "\e[1;31mnode not found.\e[0m   $1\n"
	#exit 102
fi

# check npm
if [[ -a "$(which npm)" ]]
  then 
  
	# shout out loud
	printf "\e[32mnpm found.\e[0m   $1\n"
else
	# shout out loud
	printf "\e[1;31mnpm not found.\e[0m   $1\n"
	#exit 103	
fi

# check bazinga
if [[ -a "$(which bazinga)" ]]
  then 
  
	# shout out loud
	printf "\e[32mbazinga found.\e[0m   $1\n"
else
	# install dependency
	printf "\e[32minstalling bazinga...\e[0m   $1\n"
	shinst install alternatex/bazinga
	printf "\e[32mdone.\e[0m   $1\n"
fi

# install dependencies
false && npm install && bower install

# bye
printf "\e[32mpharci is installed.\e[0m   $1\n"