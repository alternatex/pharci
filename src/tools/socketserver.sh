#!/bin/bash

# start php socket server
$PHARCI/src/Pharci/socket.php "${pharci_ipaddress}" "${pharci_port}" "${pharci_target}" "${pharci_source}"  "${pharci_output}" &

# store watch pid
socket_pid=$!

echo "socket pid is: $socket_pid"

# wait a lil for server startup
sleep 2s

# fetch filedescriptor
exec 3<>"/dev/tcp/${pharci_ipaddress}/${pharci_port}"

# helper function print command json - TODO: handle quotes!!!
function command(){
	local watch_src_path=$1
	local watch_dest_path=$2
	local watch_event_type=$3
	local watch_object=$4
	echo "{ \"watch\": \"${pharci_source}\",\"phar\": \"${pharci_target}\", \"src\": \"${watch_src_path}\", \"dest\": \"${watch_dest_path}\", \"event_type\": \"${watch_event_type}\", \"object\": \"${watch_object}\"}" >&${descriptor}
}

# shutdown socket server
function shutdown(){
	echo "shutdown" >&${descriptor}
	echo "shutting down: $socket_pid"
	kill -9 $socket_pid	#wait $socket_pid # timeout? » kill -9 $socket_pid	
}