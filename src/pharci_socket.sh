#!/bin/bash

msg_out="output message";

#~ Open socket.
exec 3<>/dev/tcp/127.0.0.1/9991

#~ Send msg.
echo "$msg_out" >&3 # OK but adds EOL character which confuses the server.
echo "$msg_out" >&3 # OK but adds EOL character which confuses the server.
echo "$msg_out" >&3 # OK but adds EOL character which confuses the server.
echo "$msg_out" >&3 # OK but adds EOL character which confuses the server.
echo "$msg_out" >&3 # OK but adds EOL character which confuses the server.
echo "$msg_out" >&3 # OK but adds EOL character which confuses the server.

# clean shutdown of client/server connection
echo "quit" >&3 # ..

#~ Receive msg.
read -r msg_in <&3
printf "msg_in: $msg_in"