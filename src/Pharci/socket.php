#!/usr/local/bin/php -q
<?php
// alias 
use Pharci\Pharci as Pharci;

// include core
require_once(__DIR__.'/pharci.php');

// shout out loud
error_reporting(E_ALL);

// hang around
set_time_limit(0);

// print input data
//ob_implicit_flush();

// extract script arguments
$address    = $argv[1];
$port       = $argv[2];
$phar       = $argv[3];
$directory  = $argv[4];
$ouput      = $argv[5];
$doecho = false;
// initialize phar
echo "initializing phar archive $phar from directory $directory".PHP_EOL;

// access phar archive
$phar = new \Phar($phar);

// inject reference to phar handler
Pharci::SetPhar($phar);

// import from directory
Pharci::Import($directory, true);

// start socket server
echo "starting php socket server... listening on ${address}:${port}".PHP_EOL;

/*
foreach($items as $item) {

  // ...
  $args = json_decode($item, true);

  // TODO: remove this
  if(!isset($argv[1])) continue;     
  
  // skip this
  if($args['event_type']==Pharci::EVENT_TYPE_MODIFIED && $args['object']==Pharci::EVENT_OBJECT_FOLDER)
    continue;  
  
  // remember *
  $_args = $args;
  
  // perform bootstrap?
  _import($argv);

  // process event
  Pharci::ProcessEvent($args['watch'], $argv[1], $args['pattern'], $args['src'], $args['dest'], $args['event_type'], $args['object']);        
}
*/

// CUSTOM COMANDS TO INSPECT PHAR ARCHIVE: list, stats
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

        $item = json_decode($buf, true);

        if(is_array($item)):
            switch($item[Pharci::ATTRIBUTE_EVENT_TYPE]){
                case Pharci::EVENT_TYPE_CREATED:
                    echo "EVENT CREATED";
                    break;
                case Pharci::EVENT_TYPE_MODIFIED:
                    echo "EVENT MODIFIED";
                    break;
                case Pharci::EVENT_TYPE_MOVED:
                    echo "EVENT MOVED";
                    break;
                case Pharci::EVENT_TYPE_DELETED:
                    echo "EVENT DELETED";
                    break;
                default:
                    echo "unknown action: ".$item[Pharci::ATTRIBUTE_EVENT_TYPE];
                    break;
            }
        else:
            echo "don't know what to do with: $buf";
        endif;

        $talkback = "PHP: You said '$buf'.\n";
        echo "$buf\n";

        socket_write($msgsock, $talkback, strlen($talkback));

        //echo "$buf\n";
    } while (true);
    socket_close($msgsock);
} while (true);

// cleanup
socket_close($sock);