#!/usr/bin/env bash

# pharci edits 
pharci_edit=false # offer?

# bazinga settings
bazinga_namespace="pharci_"
bazinga_directory=".pharcix"
bazinga_custom=".pharcix/settings.sh"

# bazinga configuration
function bazinga_gather(){
	bazinga_input "omit_files" "omit_files"	
	# todo: log directory
	# todo: ...
}