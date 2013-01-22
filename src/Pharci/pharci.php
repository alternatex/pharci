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

// TODO: fix this. think. perf. (read/write..) > stream prolly just too heavy. check tar/gz streaming?!

// initialize
if(!defined('PHARCI_INITIALIZED') && define('PHARCI_INITIALIZED', true)):

// ... 
global $args;

// include configuration
require_once(dirname(__FILE__).'/settings.php');

// core
class Pharci {

  // attributes
  const ATTRIBUTE_DEST        = 'dest';
  const ATTRIBUTE_EVENT_TYPE  = 'event_type';
  const ATTRIBUTE_OBJECT      = 'object';
  const ATTRIBUTE_PHAR        = 'phar';
  const ATTRIBUTE_SRC         = 'src';
  const ATTRIBUTE_WATCH       = 'watch';

  // event types
  const EVENT_TYPE_CREATED    = 'created';
  const EVENT_TYPE_MODIFIED   = 'modified';
  const EVENT_TYPE_MOVED      = 'moved';
  const EVENT_TYPE_DELETED    = 'deleted';
  
  // event objects
  const EVENT_OBJECT_FILE     = 'file';
  const EVENT_OBJECT_FOLDER   = 'directory';

  // patterns
  const EXCLUDE_PATTERN       = '*.tmp';
  const EXCLUDE_PATTERN_QUEUE = 'queue_';
  const INCLUDE_PATTERN_ALL   = '*';
  const INCLUDE_PATTERN       = '*';

  // filesystem
  const FILENAME_SETTINGS     = 'settings.json';
  const FILENAME_OUTDIRECTORY = '/Users/bazinga/Desktop/out/';

  // limits
  const LIMIT_CAP   = 5;
  const LIMIT_QUEUE = 5;

  // messages
  const MESSAGE_CAP_REACHED = '"cap limit reached. full rebuild. wait a lil until it\'s more quiet"';

  // system
  const PROC_KILLALL    = 'kill -9 \`ps -ef | grep "watchmedo" | grep -v grep | awk "{print $2}"\`  > /dev/null 2>&1';
  const PROC_SYNC_PHAR  = true;
  const PROC_SYNC_FS    = true;

  // miscellaneous  
  const LOGGER_TRESHOLD = 'debug';
  const PROTOCOL = 'phar://';

  // helpers
  private static $initialized = false;
  private static $logger = null;
  
  // process filesystem event
  public static function ProcessEvent($watch, $phar, $src, $pattern=self::INCLUDE_PATTERN, $dest, $event_type, $object, $log=self::LOGGER_TRESHOLD){
    
    // todo: remove this - inject ... *    
    global $args;    

    // phar-fs
    $phar_source = str_replace($watch, '', $src);
    $phar_target = str_replace($watch, '', $dest);
    
    // skip custom
    if(strpos($phar_source, self::EXCLUDE_PATTERN_QUEUE)!==false || basename($phar_source)==self::FILENAME_SETTINGS || basename($phar_source)=='.DS_Store')
      return;
    
    // log
    if(true) echo '{"'.self::ATTRIBUTE_WATCH.'": "'.$watch.'","'.self::ATTRIBUTE_PHAR.'": "'.$phar.'", "'.self::ATTRIBUTE_SRC.'": "'.$src.'", "'.self::ATTRIBUTE_DEST.'": "'.$dest.'", "'.self::ATTRIBUTE_EVENT_TYPE.'": "'.$event_type.'", "'.self::ATTRIBUTE_OBJECT.'": "'.$object.'"}';

    // initialize stream context
    $context = stream_context_create(
        array('phar' => array('compress' => \Phar::GZ)),
        array('metadata' => array('user' => 'alternatex'))
      );

    // handle by type
    switch($event_type){

      // read/write
      case self::EVENT_TYPE_CREATED:
      case self::EVENT_TYPE_MODIFIED:

        // only handle files
        if($object==self::EVENT_OBJECT_FILE) {
          
          // get fs contents
          $src_contents = file_get_contents($src);        

          // update phar contents 
          self::PROC_SYNC_PHAR && file_put_contents(self::PROTOCOL.$phar.$phar_source, $src_contents);//, 0, $context);          
          self::PROC_SYNC_FS && file_put_contents(self::FILENAME_OUTDIRECTORY.$phar_source, $src_contents);
        }

        break;
      
      // file move event -> copy / cleanup 
      case self::EVENT_TYPE_MOVED:

        // is file?
        if($object==self::EVENT_OBJECT_FILE) {
          
          // get fs contents
          $src_contents = file_get_contents($dest);
          
          // update phar contents 
          self::PROC_SYNC_PHAR && file_put_contents(self::PROTOCOL.$phar.$phar_target, $src_contents);//, 0, $context);
          self::PROC_SYNC_FS && file_put_contents(self::FILENAME_OUTDIRECTORY.$phar_target, $src_contents);

          // cleanup on file move
          self::PROC_SYNC_PHAR && (file_exists(self::PROTOCOL.$phar.$phar_source)) && unlink(self::PROTOCOL.$phar.$phar_source);
          self::PROC_SYNC_FS && (file_exists(self::FILENAME_OUTDIRECTORY.$phar_source)) && unlink(self::FILENAME_OUTDIRECTORY.$phar_source);          

        // is folder?
        } elseif($object==self::EVENT_OBJECT_FOLDER) {
          
          // ...
          //_rmdir(self::PROTOCOL.$phar.$phar_source);
          _rmdir(self::FILENAME_OUTDIRECTORY.$phar_source);                    
        }       
        break;

      // cleanup
      case self::EVENT_TYPE_DELETED:

        // is file?
        if($object==self::EVENT_OBJECT_FILE) {

          // explicit removal (might have been handled already by event_type `moved`)
          self::PROC_SYNC_PHAR && (file_exists(self::PROTOCOL.$phar.$phar_source)) && unlink(self::PROTOCOL.$phar.$phar_source);
          self::PROC_SYNC_FS  && (file_exists(self::FILENAME_OUTDIRECTORY.$phar_source)) && unlink(self::FILENAME_OUTDIRECTORY.$phar_source);
          
        } elseif($object==self::EVENT_OBJECT_FOLDER) {

          // event also fired per file on directory removal - handle only these events.
          false && _rmdir(self::PROTOCOL.$phar.$phar_source);
        }       
      default:
        break;
    }
  }

  // helper - extract $src from archive
  public static function Extract($phar, $src=self::INCLUDE_PATTERN){
    if($src==self::INCLUDE_PATTERN_ALL) {
      // ...
    } else {
      // ...
    }
  }   
}

// initialize - end
endif;