# configuration
HOST="127.0.0.1"
PORT="9991"

# define functions
socksend ()
{
	SENDME="$1"
	echo "sending: $SENDME"
	echo -ne "$SENDME" >&5 &
}

sockread ()
{
	LENGTH="$1"
	RETURN=`dd bs=$1 count=1 <&5 2> /dev/null`
}

echo "trying to open socket"
# try to connect
if ! exec 5<> /dev/udp/$HOST/$PORT; then
  echo "`basename $0`: unable to connect to $HOST:$PORT"
  exit 1
fi
echo "socket is open"

# send request
socksend "TEST"

# read 7 bytes for "success"
sockread 7
echo "RETURN: $RETURN"