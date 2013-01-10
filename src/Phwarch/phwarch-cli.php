#!/usr/bin/php
/*!
* ------------------------------------------------------------------               
* Phwarch
*
* PHP Development Utility: PHAR Auto-Updater
*
* Copyright 2013, Gianni Furger <gianni.furger@gmail.com>
* 
* https://raw.github.com/alternatex/phwarch/master/LICENSE
*
* ------------------------------------------------------------------ 
*/
 <?php

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

// run phar-update
include(dirname(__FILE__).'/settings.php');