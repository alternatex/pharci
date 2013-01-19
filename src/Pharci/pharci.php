<?php namespace Pharci;
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

// initialize
if(!defined('PHARCI_INITIALIZED') && define('PHARCI_INITIALIZED', true)):

// ... 
global $args;

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
  
  // process filesystem event
  public static function ProcessEvent($watch, $phar, $src, $dest, $event_type, $object, $log='debug'){
    
    // todo: remove this - inject ... *    
    global $args;    

    // phar-fs
    $phar_source = str_replace($watch, '', $src);
    $phar_target = str_replace($watch, '', $dest);
    
    // skip custom
    if(strpos($phar_source, 'queue_')!==false || basename($phar_source)=='/settings.json' || basename($phar_source)=='.DS_Store')
      return;
    
    // log
    // echo '{"watch": "'.$watch.'","phar": "'.$phar.'", "src": "'.$src.'", "dest": "'.$dest.'", "event_type": "'.$event_type.'", "object": "'.$object.'"}';

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

        // only handle files (TODO: think about non-prune empty directories by event? hmm.)
        if($object==Pharci::EVENT_OBJECT_FILE) {
          
          // get fs contents
          $src_contents = file_get_contents($src);        

          // update phar contents 
          file_put_contents('phar://'.$phar.$phar_source, $src_contents);//, 0, $context);
        }

        break;
      
      // file move event -> copy / cleanup - TODO: think about improvements on directory vs file deletion (capture @ pharci-watch - sleep/skip events)
      case Pharci::EVENT_TYPE_MOVED:

        // is file?
        if($object==Pharci::EVENT_OBJECT_FILE) {
          
          // get fs contents
          $src_contents = file_get_contents($dest);
          
          // update phar contents 
          file_put_contents('phar://'.$phar.$phar_target, $src_contents);//, 0, $context);

          // cleanup on file move
          if(file_exists('phar://'.$phar.$phar_source)) unlink('phar://'.$phar.$phar_source);
          
        // is folder?
        } elseif($object==Pharci::EVENT_OBJECT_FOLDER) {
          // ...
          rmdirx('phar://'.$phar.$phar_source);          
        }       
        break;

      // cleanup
      case Pharci::EVENT_TYPE_DELETED:

        // is file?
        if($object==Pharci::EVENT_OBJECT_FILE) {

          // explicit removal (might have been handled already by event_type `moved`)
          if(file_exists('phar://'.$phar.$phar_source)) unlink('phar://'.$phar.$phar_source);
        
        } elseif($object==Pharci::EVENT_OBJECT_FOLDER) {

          // event also fired per file on directory removal - handle only these events.
          false && rmdirx('phar://'.$phar.$phar_source);
        }       
      default:
        break;
    }
  }

  // helper - extract $src from archive
  public static function Extract($phar, $src=self::SOURCES_ALL){
    if($src=='*') {
      echo "Unpack all";
    } else {
      echo "Unpack $src";
    }
  }   
}

// initialize - end
endif;