#!/usr/local/bin/php -q
<?php

// inbetween * / update phar archive (when it's quite for some time...) » make sure no interference » phwrite async or sync?
// Phar::stopBuffering();
// Phar::startBuffering();

// SET TO IDLE IF MAX REACHED JUST CHECK AGAIN; IF QUIET; MATCH ALL; EXPORT
// » kill process watch and rebuild / restart when ....
// end.

// SOCKET RECEIVES WATCH PID AS FIRST MESSAGE BY CREATING A FILE W/PID!!! » 2 kill it :/

// tmpfile()
// tmpfile()
// tmpfile()
// tmpfile()
// tmpfile()

// alias 
use Pharci\Pharci as Pharci;

// include core
require_once(__DIR__.'/pharci.php');

// shout out loud
error_reporting(E_ALL);

// hang around
set_time_limit(0);

// flags
$debug      = false;
$idle       = false;

// extract script arguments
$address    = $argv[1];
$port       = $argv[2];
$phar       = $argv[3];
$directory  = $argv[4];
$ouput      = $argv[5];

// print input data
$debug && ob_implicit_flush();

// initialize phar
echo "initializing phar archive $phar from directory $directory".PHP_EOL;

// access phar archive
$phar = new \Phar($phar);

// start.
$phar->startBuffering();

// inject reference to phar handler
Pharci::SetPhar($phar);

// import from directory
Pharci::Import($directory, true);

// ...
Pharci::SetOutdir('/Users/bazinga/Desktop/outdir');

// ...
false && Pharci::Export();

// ...
$modificationsCount = 0;
$modificationsMax   = 5;

// ...
$endTime   = time()+1;

// start socket server
echo "starting php socket server... listening on ${address}:${port}".PHP_EOL;

// TODO: CUSTOM COMANDS TO INSPECT PHAR ARCHIVE: list, stats > own accessor @ server XXX
if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . PHP_EOL;
}

if (socket_bind($sock, $address, $port) === false) {
    echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . PHP_EOL;
}

if (socket_listen($sock, 5) === false) {
    echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . PHP_EOL;
}

do {
    if (($msgsock = socket_accept($sock)) === false) {
        echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)) . PHP_EOL;
        break;
    }
    /* Send instructions. */
    $msg = "\nWelcome to the PHP Test Server. \n" .
        "To quit, type 'quit'. To shut down the server type 'shutdown'.\n";
    socket_write($msgsock, $msg, strlen($msg));

    do {
        
        if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {
            echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($msgsock)) . PHP_EOL;
            break 2;
        }
        
        if (!$buf = trim($buf)) {
            continue;
        }
        
        if ($buf == 'quit') {
            break;
        }

        if ($buf == 'shutdown') { 
            $phar->stopBuffering();           
            socket_close($msgsock);
            break 2;
        }

        echo `echo \$watch_pid`;
        echo "watch pid:".$_SERVER['watch_pid']."\n";

        $args = $item = json_decode($buf, true);

        $modificationsCount++;

        if($modificationsCount>=$modificationsMax) {

            die("TOO MUCH MODIFICATIONS!!! $modificationsCount");
        } else {
            
            echo("OK $modificationsCount - $startTime - $endTime - ".($endTime-$startTime));
        }

        if($endTime<time()) {
            $modificationsCount=0;
            $endTime = time()+1;         
        }

        Pharci::ProcessEvent($args['watch'], $argv[3], $args['src'], "*", $args['dest'], $args['event_type'], $args['object']);

        //echo "$buf\n";
        $debug && socket_write($msgsock, $talkback, strlen($talkback));

    } while (true);

    // ...
    socket_close($msgsock);

} while (true);

// cleanup
socket_close($sock);