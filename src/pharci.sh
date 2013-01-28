#!/bin/bash

# verbose shell input lines
set +v

# initialize
source tools/initialize.sh

# start php socket server
source tools/socketserver.sh

# terminal-notifier - cfg
notify_group="<projectname>"

# terminal-notifier - util
function notify(){
	terminal-notifier -message "hey there" -title "my message's title" -subtitle "my message's subtitle" -execute /Applications/Safari.app/Contents/MacOS/Safari -group $notify_group	
}

# start watchdog redirect it's output to socket
watchmedo shell-command \
    --patterns="$pharci_include_pattern" \
    --wait \
    --recursive \
    --command='echo "{ \"watch\": \"${pharci_source}\",\"watch_pid\": \"${pharci_watch_pid}\",\"phar\": \"${pharci_target}\", \"src\": \"${watch_src_path}\", \"dest\": \"${watch_dest_path}\", \"event_type\": \"${watch_event_type}\", \"object\": \"${watch_object}\"}";' "$pharci_source" >&3

# shutdown server
shutdown