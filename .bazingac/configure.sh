#!/usr/bin/env bash

# bazinga settings
bazinga_namespace="pharci_"
bazinga_directory=".pharcix"
bazinga_custom=".pharcix/settings.sh"
bazinga_custom_json="settings.json"

# bazinga configuration
function bazinga_gather(){
	bazinga_input "source" "source"	
	bazinga_input "target" "target"		
	bazinga_input "interval" "interval"		
	bazinga_input "include_pattern" "include_pattern"
	bazinga_input "exclude_pattern" "exclude_pattern"	
	bazinga_input "updates_interval" "updates_interval"	
	bazinga_input "updates_max" "updates_max"		
	bazinga_input "updates_sleep" "updates_sleep"	
	bazinga_input "default_stub" "default_stub"	
}

# ...
function bazinga_postprocess(){
	printf ""
}