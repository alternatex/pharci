#!/bin/bash

# debug switch descriptor to use
descriptor=3

# command elements
pharci_source=
pharci_target=
pharci_watch_pid=
watch_src_path=
watch_dest_path=
watch_event_type=
watch_object=

# helper function print command json

# TODO: what about quotes within variables > escape quote fnc avail???

function command(){
	echo "{ \"watch\": \"${pharci_source}\",\"watch_pid\": \"${pharci_watch_pid}\",\"phar\": \"${pharci_target}\", \"src\": \"${watch_src_path}\", \"dest\": \"${watch_dest_path}\", \"event_type\": \"${watch_event_type}\", \"object\": \"${watch_object}\"}" >&${descriptor}
}

# add file
watch_event_type="added"
command