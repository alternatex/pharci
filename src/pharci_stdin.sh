#!/bin/bash

# launch watchdog // variant <shell>
watchmedo shell-command \
    --patterns="$pharci_include_pattern" \
    --wait \
    --recursive \
    --command='growlnotify -m "{ \"watch\": \"${pharci_source}\",\"watch_pid\": \"${pharci_watch_pid}\",\"phar\": \"${pharci_target}\", \"src\": \"${watch_src_path}\", \"dest\": \"${watch_dest_path}\", \"event_type\": \"${watch_event_type}\", \"object\": \"${watch_object}\"}" && echo "{ \"watch\": \"${pharci_source}\",\"watch_pid\": \"${pharci_watch_pid}\",\"phar\": \"${pharci_target}\", \"src\": \"${watch_src_path}\", \"dest\": \"${watch_dest_path}\", \"event_type\": \"${watch_event_type}\", \"object\": \"${watch_object}\"}" >> ~/queue.txt' "$pharci_source"