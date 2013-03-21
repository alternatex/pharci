#!/bin/bash

# TODO: think.
descriptor=3

# rewrite: all-in-one » TODO: think.
pharci_action="serve"

# start php socket server
$PHARCI/src/Pharci/pharci.php "${pharci_action}" "${pharci_ipaddress}" "${pharci_port}" "${pharci_target}" "${pharci_source}"  "${pharci_output}" &

# store socket pid & shout it out loud
socket_pid=$! && echo "socket server running #$socket_pid";

# wait a lil for server to startup
sleep 10s

# fetch file descriptor
exec 3<>"/dev/tcp/${pharci_ipaddress}/${pharci_port}"

# helper function print command json - TODO: handle quotes!!!
__dispatch(){

	# watchmedo placeholders
	local watch_src_path=$1
	local watch_dest_path=$2
	local watch_event_type=$3
	local watch_object=$4
	echo "{ \"watch\": \"${pharci_source}\",\"phar\": \"${pharci_target}\", \"src\": \"${watch_src_path}\", \"dest\": \"${watch_dest_path}\", \"event_type\": \"${watch_event_type}\", \"object\": \"${watch_object}\"}" >&${descriptor}
	#__socket_read 2000	
}

# ... params($bytes:bytes_to_read)
__socket_read(){
	local sread=`dd bs=$1 count=1 <&${descriptor} 2> /dev/null`
	local slen=`echo ${#sread}`
	echo "__socket_read:: $sread ($slen)"
}

# shutdown server
__shutdown(){
	sleep 3s && echo "shutdown" >&${descriptor} && sleep 1s && kill -9 $socket_pid # wait $socket_pid
}