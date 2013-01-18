<?php namespace Pharci;
global $args;
print_r($args);

function rmdirx($x){  
  try {
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
} catch(Exception $ex) {
  
}
}

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
global $args;

$ident = time();

echo "\n\nSTART: $ident\n\n";

// include configuration
require_once(dirname(__FILE__).'/settings.php');

// core
class Pharci {

  // event types
  const EVENT_TYPE_CREATED  = 'created';
  const EVENT_TYPE_MODIFIED = 'modified';
  const EVENT_TYPE_MOVED    = 'moved';
  const EVENT_TYPE_DELETED  = 'deleted';
  
  // event objects
  const EVENT_OBJECT_FILE   = 'file';
  const EVENT_OBJECT_FOLDER = 'directory';

  // ... *
  const SOURCES_ALL = '*';

  // helpers
  private static $initialized = false;
  private static $logger = null;
  
  // helper - extract from archive
  public static function Unpack($phar, $src=self::SOURCES_ALL){
    if($src=='*') {
      echo "Unpack all";
    } else {
      echo "Unpack $src";
    }
  }   

  // process filesystem event
  public static function Pack($watch, $phar, $src, $dest, $event_type, $object, $log='debug'){
    // todo: remove this - inject ... *    
    global $args;

    // phar-fs
    $phar_source = str_replace($watch, '', $src);
    $phar_target = str_replace($watch, '', $dest);
    
    // skip custom
    if(strpos($phar_source, 'queue_')!==false && $phar_source=='/settings.json' || basename($phar_source)=='.DS_Store')
      return;
    
    // Bootstrap » Fetch ProcID ???

    //exit();

    // log
    /*echo '{"watch": "'.$watch.'","phar": "'.$phar.'", "src": "'.$src.'", "dest": "'.$dest.'", "event_type": "'.$event_type.'", "object": "'.$object.'"}';
    echo "src: $src - in phar:".str_replace($watch, '', $src);
    echo "dest: $dest - in phar:".str_replace($watch, '', $dest);*/

    // initialize stream context
    $context = stream_context_create(
        array('phar' => array('compress' => \Phar::GZ)),
        array('metadata' => array('user' => 'alternatex'))
      );

    // handle by type
    switch($event_type){

      // read/write
      case Pharci::EVENT_TYPE_CREATED:
      case Pharci::EVENT_TYPE_MODIFIED:

        // is file?
        if($object==Pharci::EVENT_OBJECT_FILE) {
          
          // get fs contents
          $src_contents = file_get_contents($src);        

          // update phar contents 
          file_put_contents('phar://'.$phar.$phar_source, $src_contents);//, 0, $context);
          
          echo "PUTTING CONTENTS";

        // is folder?
        } elseif($object==Pharci::EVENT_OBJECT_FOLDER) {

          // ...
        }        
        break;
      
      // file move event -> copy / cleanup
      case Pharci::EVENT_TYPE_MOVED:
        echo "GOT MOVED";
        // is file?
        if($object==Pharci::EVENT_OBJECT_FILE) {

          echo "XXXX";
          
          // get fs contents
          $src_contents = file_get_contents($dest);
          
          // update phar contents 
          file_put_contents('phar://'.$phar.$phar_target, $src_contents);//, 0, $context);

          echo "\nnow cleanup AnD DELETE:\n  phar://".$phar.$phar_source." \n";

          // cleanup on file move
          unlink('phar://'.$phar.$phar_source);
          
        // is folder?
        } elseif($object==Pharci::EVENT_OBJECT_FOLDER) {
          // ...
          rmdirx('phar://'.$phar.$phar_source);          
        }       
        break;

      // cleanup
      case Pharci::EVENT_TYPE_DELETED:
        if($object==Pharci::EVENT_OBJECT_FILE) {
          unlink('phar://'.$phar.$phar_source);
        } elseif($object==Pharci::EVENT_OBJECT_FOLDER) {
          // event also fired per file on directory removal - handle only these events.
          rmdirx('phar://'.$phar.$phar_source);
        }       
      default:
        break;
    }
  }
}