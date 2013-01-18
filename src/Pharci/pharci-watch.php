<?php namespace Pharci;

// system
date_default_timezone_set('UTC');
$_args = null;
while(1){

	// fetch passed epoch queue file(s)
	$queues = glob('/Users/bazinga/pharci-test/queue_*');
	foreach($queues as $queue) {

		$process_queue = intval(str_replace('queue_', '', basename($queue)));
		$current_queue = intval(date('ymdhi', time()));
		if(!($process_queue<$current_queue)) continue;
		$contents = file_get_contents($queue); 
		$items = explode("\n", $contents);
		foreach($items as $item) {
			echo "ITEM: $item";
			$args = json_decode($item, true);
			if(!isset($args['phar'])) continue;			
			print_r($args);
			require_once(dirname(__FILE__).'/pharci.php');

			// skip this
			if($args['event_type']==Pharci::EVENT_TYPE_MODIFIED && $args['object']==Pharci::EVENT_OBJECT_FOLDER)
			  continue;  
			
			// remember *
			$_args = $args;

			// debug helper 
			/*if(file_exists('/Users/bazinga/Desktop/out')):
			  rmdirx('/Users/bazinga/Desktop/out');
			endif;*/

			// perform bootstrap?
			if(!file_exists($args['phar'])) {
			  
			  // initialize archive
			  $phar = new \Phar($args['phar'], 0, basename($args['phar']));
			  
			  // bootstrap
			  $phar->buildFromDirectory('/Users/bazinga/pharci-test');
			  
			  // release
			  $phar = null; 
			  
			  // remove custom settings
			  unlink('phar://'.$args['phar'].'/settings.json');
			}

			// process event
			Pharci::Pack($args['watch'], $args['phar'], $args['src'], $args['dest'], $args['event_type'], $args['object']);

			// logging *
			echo "\n\nEND: $ident";
		}
		echo "\n\n\nDELETE QUEUE: $queue\n\n\n\n\n";		
		unlink($queue);		
		// debug helper 
		$x='/Users/bazinga/Desktop/out';
		if(file_exists($x)):		  
		  $it = new \RecursiveDirectoryIterator($x);
		  $files = new \RecursiveIteratorIterator($it,
		               \RecursiveIteratorIterator::CHILD_FIRST);
		  foreach($files as $file){
		      if(strpos($x, 'phar://')!==FALSE)
		        echo "\nfile's realpath is: ".$file->getRealPath();
		      
		      if ($file->isDir()){
		          rmdir($file->getRealPath());
		      } else {
		          if(file_exists($file->getRealPath()))
		            unlink($file->getRealPath());
		      }
		  }		
		endif;				
		
		if(isset($_args['phar'])) {
			echo "\nextracting...\n";
			$phar = new \Phar($_args['phar']);
			$phar->extractTo ('/Users/bazinga/Desktop/out', null, true);
		}

	}
}