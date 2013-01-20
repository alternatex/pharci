<?php namespace Pharci;
/*!
* ------------------------------------------------------------------               
* Pharci
*
* PHP development utility to automate filesystem > phar 
* replication by monitoring filesystem modifications using 
* [watchdog](https://github.com/gorakhargosh/watchdog/)
*
* Copyright 2013, Gianni Furger <gianni.furger@gmail.com>
* 
* https://raw.github.com/alternatex/pharci/master/LICENSE
*
* ------------------------------------------------------------------ 
*/

// TODO: fix this. think. perf. (read/write..)

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

  const PROC_KILLALL = 'kill -9 \`ps -ef | grep "watchmedo" | grep -v grep | awk "{print $2}"\`  > /dev/null 2>&1';

  // default file patterns
  const INCLUDE_PATTERN = '*';
  const EXCLUDE_PATTERN = '';

  // miscellaneous
  const PROTOCOL = 'phar://';
  const FILENAME_SETTINGS = 'settings.json';
  const LOGGER_TRESHOLD = 'debug';

  // helpers
  private static $initialized = false;
  private static $logger = null;
  
  // process filesystem event
  public static function ProcessEvent($watch, $phar, $src, $pattern=Pharci::INCLUDE_PATTERN, $dest, $event_type, $object, $log=Pharci::LOGGER_TRESHOLD){
    
    // todo: remove this - inject ... *    
    global $args;    

    // phar-fs
    $phar_source = str_replace($watch, '', $src);
    $phar_target = str_replace($watch, '', $dest);
    
    // skip custom
    if(strpos($phar_source, 'queue_')!==false || basename($phar_source)==Pharci::FILENAME_SETTINGS || basename($phar_source)=='.DS_Store')
      return;
    
    // log
    if(true) echo '{"watch": "'.$watch.'","phar": "'.$phar.'", "src": "'.$src.'", "dest": "'.$dest.'", "event_type": "'.$event_type.'", "object": "'.$object.'"}';

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

        // only handle files
        if($object==Pharci::EVENT_OBJECT_FILE) {
          
          // get fs contents
          $src_contents = file_get_contents($src);        

          // update phar contents 
          //file_put_contents(Pharci::PROTOCOL.$phar.$phar_source, $src_contents);//, 0, $context);
          echo "\nfile put contents: /Users/bazinga/Desktop/out/$phar_source\n";
          file_put_contents("/Users/bazinga/Desktop/out/".$phar_source, $src_contents);
        }

        break;
      
      // file move event -> copy / cleanup 
      case Pharci::EVENT_TYPE_MOVED:

        // is file?
        if($object==Pharci::EVENT_OBJECT_FILE) {
          
          // get fs contents
          $src_contents = file_get_contents($dest);
          
          // update phar contents 
          //file_put_contents(Pharci::PROTOCOL.$phar.$phar_target, $src_contents);//, 0, $context);
          file_put_contents("/Users/bazinga/Desktop/out/".$phar_target, $src_contents);

          // cleanup on file move
          //if(file_exists(Pharci::PROTOCOL.$phar.$phar_source)) unlink(Pharci::PROTOCOL.$phar.$phar_source);
          if(file_exists("/Users/bazinga/Desktop/out/".$phar_source)) unlink("/Users/bazinga/Desktop/out/".$phar_source);          

        // is folder?
        } elseif($object==Pharci::EVENT_OBJECT_FOLDER) {
          
          // ...
          //rmdirx(Pharci::PROTOCOL.$phar.$phar_source);
          rmdirx("/Users/bazinga/Desktop/out/".$phar_source);                    
        }       
        break;

      // cleanup
      case Pharci::EVENT_TYPE_DELETED:

        // is file?
        if($object==Pharci::EVENT_OBJECT_FILE) {

          // explicit removal (might have been handled already by event_type `moved`)
          //if(file_exists(Pharci::PROTOCOL.$phar.$phar_source)) unlink(Pharci::PROTOCOL.$phar.$phar_source);
          if(file_exists("/Users/bazinga/Desktop/out/".$phar_source)) unlink("/Users/bazinga/Desktop/out/".$phar_source);
          
        } elseif($object==Pharci::EVENT_OBJECT_FOLDER) {

          // event also fired per file on directory removal - handle only these events.
          false && rmdirx(Pharci::PROTOCOL.$phar.$phar_source);
        }       
      default:
        break;
    }
  }

  // helper - extract $src from archive
  public static function Extract($phar, $src=self::INCLUDE_PATTERN){
    if($src=='*') {
      echo "Unpack all";
    } else {
      echo "Unpack $src";
    }
  }   
}

// initialize - end
endif;