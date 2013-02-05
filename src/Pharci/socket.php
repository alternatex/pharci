#!/usr/local/bin/php -q
<?php

// flags
$debug = false;

// alias 
use Pharci\Pharci as Pharci;

// include core
require_once(__DIR__.'/pharci.php');

// shout out loud
error_reporting(E_ALL);

// hang around
set_time_limit(0);

// print input data
$debug && ob_implicit_flush();

// extract script arguments
$address    = $argv[1];
$port       = $argv[2];
$phar       = $argv[3];
$directory  = $argv[4];
$ouput      = $argv[5];

// initialize phar
echo "initializing phar archive $phar from directory $directory".PHP_EOL;

// access phar archive
$phar = new \Phar($phar);

// inject reference to phar handler
Pharci::SetPhar($phar);

// import from directory
Pharci::Import($directory, true);

// ...
false && Pharci::Export('/Users/bazinga/Desktop/outdir');

// start socket server
echo "starting php socket server... listening on ${address}:${port}".PHP_EOL;

// Pharci::ProcessEvent($args['watch'], $argv[1], $args['pattern'], $args['src'], $args['dest'], $args['event_type'], $args['object']);        

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
            socket_close($msgsock);
            break 2;
        }

        $args = $item = json_decode($buf, true);

        Pharci::ProcessEvent($args['watch'], $argv[3], $args['src'], "*", $args['dest'], $args['event_type'], $args['object']);

        //echo "$buf\n";
        $debug && socket_write($msgsock, $talkback, strlen($talkback));

    } while (true);

    // ...
    socket_close($msgsock);
} while (true);

// cleanup
socket_close($sock);