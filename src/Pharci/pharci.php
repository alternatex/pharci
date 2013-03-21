<?php namespace Pharci;

/*!
* ------------------------------------------------------------------               
* Pharci
*
* PHP development utility to automate filesystem to phar 
* replication by monitoring filesystem modifications using 
* [watchdog](https://github.com/gorakhargosh/watchdog)
*
* Copyright 2013, Gianni Furger <gianni.furger@gmail.com>
* 
* https://raw.github.com/alternatex/pharci/master/LICENSE
*
* ------------------------------------------------------------------ 
*/

// ------------------------------------------------------
// - prerequisites check (really, everytime? TODO: solve)
// ------------------------------------------------------

// prerequisites - check phar write support
if(!\Phar::canWrite()):

  // give up
  die("Error: ".
      "Phar::canWrite() evaluates to `false`.".
      "Ensure php.ini includes phar.readonly=Off to enable creation and modification of phar archives using the phar stream or phar object's write support.");
endif;

// ------------------------------------------------------
// - initialize
// ------------------------------------------------------

// include configuration » read $settings and extract contents into global namespace
if(file_exists(Pharci\Pharci::FILENAME_SETTINGS)) extract(json_decode(file_get_contents(Pharci\Pharci::FILENAME_SETTINGS),true));

// ------------------------------------------------------
// - process
// ------------------------------------------------------

// determine execution mode » start socket server or process input
if(($pharci_action = $argv[1])===MODE_SOCKETSERVER):

  // helpers
  $argv_index = 2;

  // ...
  $address    = $argv[$argv_index++];
  $port       = $argv[$argv_index++];
  $phar       = $argv[$argv_index++];
  $directory  = $argv[$argv_index++];
  $ouput      = $argv[$argv_index++];  

  // ...
  Pharci::StartServer($address, $port, $phar, $directory, $output);

  // ...
  die('TILT!');

endif;

// core
class Pharci {

  // attributes
  const ATTRIBUTE_DEST        = 'dest';
  const ATTRIBUTE_EVENT_TYPE  = 'event_type';
  const ATTRIBUTE_OBJECT      = 'object';
  const ATTRIBUTE_PATTERN     = 'pattern';
  const ATTRIBUTE_PHAR        = 'phar';
  const ATTRIBUTE_SRC         = 'src';
  const ATTRIBUTE_WATCH       = 'watch';
  const ATTRIBUTE_WATCH_PID   = 'watch_pid';

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
  const INCLUDE_PATTERN       = '*';
  const INCLUDE_PATTERN_ALL   = '*';

  // filesystem
  const FILENAME_OUTDIRECTORY = '/Users/bazinga/Desktop/out/';
  const FILENAME_QUEUE_PREFIX = 'queue_';
  const FILENAME_QUEUE_SUFFIX = 'ymdhis';
  const FILENAME_SETTINGS     = 'settings.json';
  
  // limits
  const LIMIT_UPDATES_PTU     = 5; # updates per time unit (wich is=XXX?!)
  const LIMIT_UPDATES_TU      = 1;

  // messages
  const MESSAGE_CAP_REACHED = '"cap limit reached. full rebuild. wait a lil until it\'s more quiet"';

  // system
  const PROC_KILLALL    = 'kill -9 \`ps -ef | grep "watchmedo" | grep -v grep | awk "{print $2}"\`  > /dev/null 2>&1';
  const PROC_SYNC_PHAR  = true;
  const PROC_SYNC_FS    = true;

  // miscellaneous  
  const MODE_SOCKETSERVER = 'serve';
  const LOGGER_TRESHOLD = 'debug';
  const PROTOCOL = 'phar://';

  // helpers
  private static $initialized = false;
  private static $logger = null;
  private static $phar = null;
  private static $modifications = 0;
  private static $outdir = '.';

  public static function SetOutdir($outdir){
    self::$outdir = $outdir;
  }

  public static function SetPhar(&$phar){
    self::$phar=$phar;
  }
  
  // process filesystem event
  public static function ProcessEvent($watch, $phar, $src, $pattern=self::INCLUDE_PATTERN, $dest, $event_type, $object, $log=self::LOGGER_TRESHOLD){    
    
    // abstract modification/event count
    self::$modifications++;

    // phar-fs
    $phar_source = str_replace($watch, '', $src);
    $phar_target = str_replace($watch, '', $dest);
    
    if(self::$modifications%100==0) {
      self::$phar->stopBuffering();
      //self::Export();
      self::$phar->startBuffering();
    }

    // skip custom
    if(strpos($phar_source, self::FILENAME_QUEUE_PREFIX)!==false || basename($phar_source)==self::FILENAME_SETTINGS || basename($phar_source)=='.DS_Store')
      return;
    
    // log
    if(false) echo '{"'.self::ATTRIBUTE_WATCH.'": "'.$watch.'","'.self::ATTRIBUTE_PHAR.'": "'.$phar.'", "'.self::ATTRIBUTE_SRC.'": "'.$src.'", "'.self::ATTRIBUTE_DEST.'": "'.$dest.'", "'.self::ATTRIBUTE_EVENT_TYPE.'": "'.$event_type.'", "'.self::ATTRIBUTE_OBJECT.'": "'.$object.'"}';

    // initialize stream context
    $context = stream_context_create(
        array('phar' => array('compress' => \Phar::GZ)),
        array('metadata' => array('user' => 'alternatex'))
      );

    // determine call-delegate
    $delegate=ucfirst($object).ucfirst($event_type);

    // check delegate's existance
    if(method_exists(self, $delegate)) {

      // TODO: finalize implementation *
      echo "AUTOM XXXX";

      // exec delegate
      self::$delegate($src, $dest);
    }
  }

  // ...
  public static function FileCreated($filepath){
    echo __FUNCTION__." $filepath";
    self::$phar->addFile($filepath);
  }

  // ...
  public static function FileModified($filepath){
    echo __FUNCTION__." $filepath";
    self::FileCreated($filepath);
  }

  // ...
  public static function FileMoved($source, $destination){
    echo __FUNCTION__."$source $destination";
    self::$phar->addFile($destination);
    self::$phar->delete($source);
   
  }

  // ...
  public static function FileDeleted($filepath){
    echo __FUNCTION__."$filepath";
    self::$phar->delete($filepath);
  }

  // ...
  public static function DirectoryCreated(){

  }

  // ...
  public static function DirectoryModified(){

  }

  // ...
  public static function DirectoryMoved(){

  }

  // ...
  public static function DirectoryDeleted(){
    self::$phar->delete($filepath);
  }  

  // helper - extract $src from archive
  public static function Extract($phar, $src=self::INCLUDE_PATTERN){
    if($src==self::INCLUDE_PATTERN_ALL) {
      // ...
    } else {
      // ...
    }
  }  

   // helper - phar import
  public static function Import($directory, $force=false){

    // ...
    if($force || !file_exists($directory)) {  

      // bootstrap
      self::$phar->buildFromDirectory($directory);
    }  
  }

  // helper - phar export
  public static function Export($directory=''){
    if($directory=='') $directory = self::$outdir;
    self::$phar->extractTo($directory, null, true);
  }

  // ------------------------------------------------------
  // - helpers - socket server
  // ------------------------------------------------------

  public static function StartServer($address, $port, $phar, $directory, $output, $debug=false, $idle=false){

    // shout out loud
    error_reporting(E_ALL);

    // hang around
    set_time_limit(0);

    // print input data
    $debug && ob_implicit_flush();

    // initialize phar
    echo "initializing phar archive $phar from directory $directory".PHP_EOL;

    // access phar archive
    $phar = new \Phar($phar);

    // start.
    $phar->startBuffering();

    // inject reference to phar handler
    Pharci::SetPhar($phar);

    // import from directory
    Pharci::Import($directory, true);

    // ...
    Pharci::SetOutdir('/Users/bazinga/Desktop/outdir');

    // ...
    false && Pharci::Export();

    // ...
    $modificationsCount = 0;
    $modificationsMax   = 500000;

    // ...
    $endTime   = time()+1;

    // start socket server
    echo "starting php socket server... listening on ${address}:${port}".PHP_EOL;

    // TODO: CUSTOM COMANDS TO INSPECT PHAR ARCHIVE: list, stats > own accessor @ server XXX
    if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
        echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . PHP_EOL;
    }

    if (socket_bind($sock, $address, $port) === false) {
        echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . PHP_EOL;
    }

    if (socket_listen($sock, 5) === false) {
        echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . PHP_EOL;
    }

    do {
        if (($msgsock = socket_accept($sock)) === false) {
            echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)) . PHP_EOL;
            break;
        }
        /* Send instructions. */
        $msg = "\nWelcome to the PHP Test Server. \n" .
            "To quit, type 'quit'. To shut down the server type 'shutdown'.\n";
        socket_write($msgsock, $msg, strlen($msg));

        do {
            
            if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {
                echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($msgsock)) . PHP_EOL;
                break 2;
            }
            
            if (!$buf = trim($buf)) {
                continue;
            }
            
            if ($buf == 'quit') {
                break;
            }

            if ($buf == 'shutdown') { 
                $phar->stopBuffering();           
                socket_close($msgsock);
                break 2;
            }

            echo `echo \$watch_pid`;
            echo "watch pid:".$_SERVER['watch_pid']."\n";

            $args = $item = json_decode($buf, true);

            $modificationsCount++;

            if($modificationsCount>=$modificationsMax) {

                die("TOO MUCH MODIFICATIONS!!! $modificationsCount");
            } else {
                
                echo("OK $modificationsCount - $startTime - $endTime - ".($endTime-$startTime));
            }

            if($endTime<time()) {
                $modificationsCount=0;
                $endTime = time()+1;         
            }

            Pharci::ProcessEvent($args['watch'], $argv[3], $args['src'], "*", $args['dest'], $args['event_type'], $args['object']);

            //echo "$buf\n";
            $debug && socket_write($msgsock, $talkback, strlen($talkback));

        } while (true);

        // ...
        socket_close($msgsock);

    } while (true);

    // cleanup
    socket_close($sock);
  }

  // ...
  public static function StopServer(){

    // ...
  }

  // ------------------------------------------------------
  // - helpers - file system operations
  // ------------------------------------------------------

  public static function RemoveDirectory($path){
    try {
      if(!file_exists($path)) return false;
      $it = new \RecursiveDirectoryIterator($path);
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
} // class-def end