#!/usr/bin/env bash

# phwarch edits 
phwarch_edit=false # offer?

# bazinga settings
bazinga_namespace="phwarch_"
bazinga_directory=".phwarchx"
bazinga_custom=".phwarchx/settings.sh"

# bazinga configuration
function bazinga_gather(){
	bazinga_input "omit_files" "omit_files"	
	# todo: log directory
	# todo: ...
}