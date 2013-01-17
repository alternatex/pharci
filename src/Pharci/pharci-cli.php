#!/usr/bin/php
/*!
* ------------------------------------------------------------------               
* Pharci
*
* PHP development utility to automate replication of files and 
* folders into PHAR-archives by monitoring filesystem modifications 
* using [watchdog](https://github.com/gorakhargosh/watchdog/)
*
* Copyright 2013, Gianni Furger <gianni.furger@gmail.com>
* 
* https://raw.github.com/alternatex/pharci/master/LICENSE
*
* ------------------------------------------------------------------ 
*/
 <?php

// omit scriptname
array_shift($argv);

// extract arguments
$args = array_combine(array('src', 'dest', 'event_type', 'object'), $argv);

// run phar-update
include(dirname(__FILE__).'/pharci.php');

// atm only positional options supported
exit;

// getopt helpers - params
$options='';
$longopts=array('dir', 'file', 'events');

// getopt helpers - initialize
array_map(function($option){

	// set shortopt as first char o longopt (yeah, I know..)
	$options.=substr($option, 0, 1).':';

}, $longopts);

// retrieve commandline args
$args = getopt($options, $longopts);