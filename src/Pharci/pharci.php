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
global $args;

require_once(dirname(__FILE__).'/settings.php');

// TODO SKIP CLASS ONE-SHOT ONLY ??? NO. @ ALWAYS - HOW TO SYNCHRONIZE??
// TMP MESSAGEQUEUES?

class Pharci {

  // event types
  const EVENT_TYPE_CREATED = 'created';
  const EVENT_TYPE_MODIFIED = 'modified';
  const EVENT_TYPE_MOVED = 'moved';
  const EVENT_TYPE_DELETED = 'deleted';
  
  // objects
  const EVENT_OBJECT_FILE = 'file';
  const EVENT_OBJECT_DIRECTORY = 'directory';

  // helpers
  private static $initialized = false;
  private static $logger = null;

  // singleton constructor
  private static function getInstance(){
    // require log4php 
    // ...
  }
  
  // process filesystem event
  public static function Process($phar, $src, $dest, $event_type, $object, $log='debug'){
    
    echo "event_type: $event_type";

    print_r($argv);
    global $args;
    print_r($args);

    // handle by type
    switch($event_type){
      case Pharci::EVENT_TYPE_CREATED:
        if($object=='file') {
          $src_contents = file_get_contents($src);
          echo "src_contents: $src_contents";
          $dest_contents = file_get_contents($dest);
          echo "src_contents: $dest_contents";
          if(file_exists($dest)) {

          }
        } elseif($object=='directory') {
          // ...
        }        
        break;
      case Pharci::EVENT_TYPE_MODIFIED:
        break;
      case Pharci::EVENT_TYPE_MOVED:
        break;
      case Pharci::EVENT_TYPE_DELETED:
        break;
      default:
        break;
    }
    // basename
    // filepath
    // ...
    // mkdir if add
    // add/update | remove
    // rmdir if empty

    $context = stream_context_create(
          array('phar' => array('compress' => \Phar::GZ)),
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

// process event
Pharci::Process('myphar.phar', $args['src'], $args['dest'], $args['event_type'], $args['object']);