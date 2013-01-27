#!/bin/bash
cat $PHARCI/src/Pharci/socket.php
# start php socket server
$PHARCI/src/Pharci/socket.php "${pharci_ipaddress}" "${pharci_port}" "${pharci_target}" "${pharci_source}"  "${pharci_output}" &

# store watch pid
socket_pid=$!

# talk
echo "socket server running #$socket_pid";

# wait a lil for server startup
sleep 3s

# fetch file descriptor
exec 3<>"/dev/tcp/${pharci_ipaddress}/${pharci_port}"

# helper function print command json - TODO: handle quotes!!!
dispatch(){
	#echo "DISPATCH"
	# TODO: ensure required globals/environment variables set
	# watchmedo placeholders
	local watch_src_path=$1
	local watch_dest_path=$2
	local watch_event_type=$3
	local watch_object=$4
	echo "{ \"watch\": \"${pharci_source}\",\"phar\": \"${pharci_target}\", \"src\": \"${watch_src_path}\", \"dest\": \"${watch_dest_path}\", \"event_type\": \"${watch_event_type}\", \"object\": \"${watch_object}\"}" >&${descriptor}

	#sockread 2000	
}

sockread(){
	LENGTH="$1"
	RETURN=`dd bs=$1 count=1 <&${descriptor} 2> /dev/null`
	local tmp_len=`echo ${#RETURN}`
	#echo "SOCKREAD SAYS: $tmp_len $RETURN"
}

# shutdown socket server
shutdown(){
	timer=3s
	#echo "shutting down in: $timer"
	sleep $timer
	kill -9 $socket_pid
	#echo "shutdown" >&${descriptor}
	
	#wait $socket_pid
}