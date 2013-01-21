<?php namespace Pharci;

// TODO: fix performance * - fs osx vs. *nix
// TODO: fix performance * - fs osx vs. *nix
// TODO: fix performance * - fs osx vs. *nix
// TODO: fix performance * - fs osx vs. *nix
// TODO: fix performance * - fs osx vs. *nix

// ... 
require_once(dirname(__FILE__).'/pharci.php');

// ..
define('PHARCI_DEBUG', false);

// initialize stream context
$context = stream_context_create(
  array('phar' => array('compress' => \Phar::GZ)),
  array('metadata' => array('user' => 'alternatex'))
);

// settings
date_default_timezone_set('UTC');

// helpers
$_args = null;

// inifinite.
while(1){ 

  // fetch passed epoch queue file(s)
  $queues = glob('/Users/bazinga/pharci-test/queue_*');

  // ...
  if(PHARCI_DEBUG && sizeof($queues)>Pharci::LIMIT_QUEUE) { 

    // ...
    print Pharci::MESSAGE_CAP_REACHED;

    // ...
    print `kill -9 `.$args['watch_pid'];

    // ...
    eval('`'.Pharci::PROC_KILLALL.'`');
  }

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
    if(PHARCI_DEBUG &&  sizeof($queues)>Pharci::LIMIT_QUEUE) { 

      // ...
      print Pharci::MESSAGE_CAP_REACHED;

      // ...
      eval('`'.Pharci::PROC_KILLALL.'`');

      // ...
      do { $queues = $tmp_queues; sleep(1); $tmp_queues = glob('/Users/bazinga/pharci-test/queue_*'); } while(sizeof($tmp_queues)>sizeof($queues));

      // remove queues - TODO: think. queue copied inbetween > skip at $phar->buildFromDirectory
      foreach($queues as $queue) { if(file_exists($queue)) unlink($queue); }
          
      // define based on settings based on settings 
      $phar_regex = '';
      
      // debug - export
      (!PHARCI_DEBUG) && isset($argv[1]) && file_exists($argv[1]) && _export($argv);

      // continue parent
      break;
    }
    
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

    // cleanup
    if(file_exists($queue)) unlink($queue);   
    
    // debug - cleanup 
    PHARCI_DEBUG && _rmdir('/Users/bazinga/Desktop/out');
  }

  // debug - export
  true && isset($argv[1]) && file_exists($argv[1]) && _export($argv);

  // ...
  sleep(1);
}

// helper - phar import
function _import($argv, $force=false){

  // ...
  if($force || !file_exists($argv[1])) {  

    // initialize archive
    $phar = new \Phar($argv[1], 0, basename($argv[1]));

    // bootstrap
    $phar->buildFromDirectory('/Users/bazinga/pharci-test');

    // release
    $phar = null; 

    // remove custom settings 
    unlink(Pharci::PROTOCOL.$argv[1].Pharci::FILENAME_SETTINGS);
  }
}

// helper - phar export
function _export($argv){
  $phar = new \Phar($argv[1]);
  $phar->extractTo ('/Users/bazinga/Desktop/out', null, true);
}

// helper - fs delete
function _rmdir($x){  
  try {
    if(!file_exists($x)) return false;
    $it = new \RecursiveDirectoryIterator($x);
    $files = new \RecursiveIteratorIterator($it,
                 \RecursiveIteratorIterator::CHILD_FIRST);
    foreach($files as $file){
      if ($file->isDir()){
          if(file_exists($file->getRealPath())) rmdir($file->getRealPath());
      } else {
          if(file_exists($file->getRealPath()))
            unlink($file->getRealPath());
      }
    }
  } catch(Exception $ex) {}
}