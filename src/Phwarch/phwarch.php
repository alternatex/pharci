<?php namespace Phwarch;
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

# EVENTS: CREATE, MODIFY, MOVE_FROM, MOVE_TO, DELETE

require_once(dirname(__FILE__).'/settings.php');

class Phwarch {

	// ...
	private static $initialized = false;
	private static $logger = null;

	// ...
	private static function Initialize(){
		// require log4php 
		// ...
	}
	
	// ...
	public static function Update($path, $file, $event, $log='debug'){

		// basename
		// filepath
		// ...
		// mkdir if add
		// add/update | remove
		// rmdir if empty

		$context = stream_context_create(
    	    array('phar' => array('compress' => Phar::GZ)),
            array('metadata' => array('user' => 'cellog'))
        );

		$current = file_get_contents('phar://my.phar/somefile.php', 0, $context);
		
		echo "current: $current";

		file_put_contents('phar://my.phar/somefile.php', 'lalala'.$current, 0, $context);
	}

	// ...
	private function __construct(){}

	// ...	
	private function __destruct(){}
}

Phwarch::Update('myphar.phar', 'filex_xxx', 'action_add | action_remove');