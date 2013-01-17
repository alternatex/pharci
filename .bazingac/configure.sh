#!/usr/bin/env bash

# pharci edits 
pharci_edit=false # offer?

# bazinga settings
bazinga_namespace="pharci_"
bazinga_directory=".pharcix"
bazinga_custom=".pharcix/settings.sh"
bazinga_custom_json="settings.json"

# bazinga configuration
function bazinga_gather(){
	bazinga_input "input_directory" "input_directory"	
	bazinga_input "output_directory" "output_directory"	
}

# ...
function bazinga_postprocess(){
	echo "..."
}