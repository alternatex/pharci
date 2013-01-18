#!/usr/bin/php 
<?php

// system
date_default_timezone_set('UTC');

// omit scriptname
array_shift($argv);

// getopts
$options=''; $longopts=array('watch', 'phar', 'src', 'dest', 'event_type', 'object');

// getopt helpers - initialize
false && array_map(function($option){

	// set shortopt as first char o longopt (yeah, I know..)
	$options.=substr($option, 0, 1).':';

}, $longopts);

// extract arguments
$args = array_combine($longopts, $argv); // getopt($options, $longopts);

// ...
if(strpos($args['src'], 'queue_')===FALSE) {

	// determine epoch
	$queue_file = 'queue_'.date('ymdhi', time());
	
	//echo "queuefile: $queue_file";
	file_put_contents($queue_file, (file_exists($queue_file)?"\n":'').json_encode($args), FILE_APPEND);
}