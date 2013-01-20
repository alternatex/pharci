#!/usr/bin/php 
<?php

// system
date_default_timezone_set('UTC');

// omit scriptname
array_shift($argv);

// talk XXX
if($DEBUG=false) print_r($argv);

// getopts
$options=''; $longopts=array('watch_pid', 'watch', 'phar', 'src', 'pattern', 'dest', 'event_type', 'object');

// getopt helpers - initialize
false && array_map(function($option){

  // set shortopt as first char o longopt (yeah, I know..)
  $options.=substr($option, 0, 1).':';

}, $longopts);

// extract arguments
$args = array_combine($longopts, $argv); // getopt($options, $longopts);
echo "PID KICKER".$args['watch_pid'];
print_r($args);
// skip / process
if(strpos($args['src'], 'queue_')===FALSE && strpos($args['src'], 'settings.json')===FALSE && strpos($args['src'], '.DS_Store')===FALSE && (!($args['event_type']=="modified" && $args['object']=="directory"))) { 

  // determine epoch
  $queue_file = 'queue_'.date('ymdhis', time());

  // update queue
  file_put_contents($queue_file, (file_exists($queue_file)?"\n":'').json_encode($args), FILE_APPEND);

  echo "queue file written: $queue_file!".file_exists($queue_file);
}
echo "\nkickde xxx \n";