#!/bin/sh

# configure
watchdir='workspace'
format='-d "%w" -f "%f" -e "%e"'

# watch directory / dispatch events / exec phar update
inotifywait --recursive --monitor --quiet --event modify,create,delete,move --format "${format}" "${watchdir}" | 
while read FILE ; do    	
	./Phwarch/phwarch-cli.php $FILE
done

# think: manifest » integrity check @@@ startup!