<?php namespace Pharci;

// TODO: implement modification count per time unit as condition for partial / full updates
// TODO: on error rebuild // think. handle.

// constants
define('PHARCI_CAP', 5);
define('PHARCI_MAX_QUEUES', 5);

// settings
date_default_timezone_set('UTC');

// helpers
$_args = null;

function rmdirx($x){  
  try {
    if(!file_exists($x)) return false;
    $it = new \RecursiveDirectoryIterator($x);
    $files = new \RecursiveIteratorIterator($it,
                 \RecursiveIteratorIterator::CHILD_FIRST);
    foreach($files as $file){
      if ($file->isDir()){
          rmdir($file->getRealPath());
      } else {
          if(file_exists($file->getRealPath()))
            unlink($file->getRealPath());
      }
    }
  } catch(Exception $ex) {}
}

// inifinite.
while(1){ 

  // fetch passed epoch queue file(s)
  $queues = glob('/Users/bazinga/pharci-test/queue_*');

  // TODO: check max queues
  // process each > validation/wait/sleep XXX > "thread safety"
  foreach($queues as $queue) {

    // ...
    $process_queue = intval(str_replace('queue_', '', basename($queue)));

    // determine current here - TODO: think. better or worse if moved to parent loop?
    $current_queue = intval(date('ymdhis', time()));

    // this should ensure "thread safety". rofl.
    if(!($process_queue<$current_queue-3)) continue;

    // fetch items
    $items = explode("\n", file_get_contents($queue));

    // determine modification cap reached?
    if(sizeof($items)>PHARCI_CAP) { echo "cap limit reached. full rebuild. wait a lil until it's more quiet";
                        
      $tmp_queues = glob('/Users/bazinga/pharci-test/queue_*');

      do {
        echo "\n already got more... * \n";
        $queues = $tmp_queues;
        sleep(2);
        $tmp_queues = glob('/Users/bazinga/pharci-test/queue_*');
      } while(sizeof($tmp_queues)>sizeof($queues));
      /*
      if(sizeof($tmp_queues)>sizeof($queues)) {
        $last = sizeof($tmp_queues);
        while($last)
      }
      */

      // remove queues - TODO: think. queue copied inbetween > skip at $phar->buildFromDirectory
      foreach($queues as $queue) { if(file_exists($queue)) unlink($queue); }
      
      // remove archive
      if(file_exists($args['phar'])) unlink($args['phar']);
        
      // initialize archive
      $phar = new \Phar($args['phar'], 0, basename($args['phar']));
    
      // bootstrap (TODO: handle excluded files ?! settings.json/queue_*/...)
      $phar->buildFromDirectory('/Users/bazinga/pharci-test');
              
      // remove custom settings 
      if(file_exists('phar://'.$args['phar'].'/settings.json')) unlink('phar://'.$args['phar'].'/settings.json');

      // release
      $phar = null; 

      // export XXX
      $phar = new \Phar($_args['phar']);
      $phar->extractTo ('/Users/bazinga/Desktop/out', null, true);

      // TODO: think
      sleep(10);

      // continue parent
      break;
    }

    foreach($items as $item) {
      
      // ...
      $args = json_decode($item, true);

      // TODO: remove this
      if(!isset($args['phar'])) continue;     
      
      // ...
      require_once(dirname(__FILE__).'/pharci.php');

      // skip this
      if($args['event_type']==Pharci::EVENT_TYPE_MODIFIED && $args['object']==Pharci::EVENT_OBJECT_FOLDER)
        continue;  
      
      // remember *
      $_args = $args;
      
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
    }

    // cleanup
    if(file_exists($queue)) unlink($queue);   
    
    // debug - cleanup 
    rmdirx('/Users/bazinga/Desktop/out');
      
    // debug - export
    $phar = new \Phar($_args['phar']);
    $phar->extractTo ('/Users/bazinga/Desktop/out', null, true);
  }
}