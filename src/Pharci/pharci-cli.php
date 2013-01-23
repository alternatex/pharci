#!/usr/bin/php 
<?php 

/* «bash inclusion snippet»
# ---------------------------------------------------------
# launch watchdog // variant <php>
# ---------------------------------------------------------
watchmedo shell-command \
    --interval=1000 \
    --wait \
    --patterns="$pharci_include_pattern" \
    --recursive \
    --command='${PHARCI}/src/Pharci/pharci-cli.php "${pharci_source}" "${pharci_target}" "${watch_src_path}" "${watch_dest_path}" "${watch_event_type}" "${watch_object}"' "$phar_source" 
# ---------------------------------------------------------    
*/	    

// ... 
require_once(dirname(__FILE__).'/pharci.php');

// system
date_default_timezone_set('UTC');

// omit scriptname
array_shift($argv);

// getopts
$options=''; $longopts=array(Pharci::ATTRIBUTE_WATCH_PID, Pharci::ATTRIBUTE_WATCH, Pharci::ATTRIBUTE_PHAR , Pharci::ATTRIBUTE_SRC, Pharci::ATTRIBUTE_PATTERN, Pharci::ATTRIBUTE_DEST, Pharci::ATTRIBUTE_EVENT_TYPE, Pharci::ATTRIBUTE_OBJECT);

// extract arguments
$args = array_combine($longopts, $argv);

// skip / process
if(strpos($args[Pharci::ATTRIBUTE_SRC], Pharci::FILENAME_QUEUE_PREFIX)===FALSE && strpos($args[Pharci::ATTRIBUTE_SRC], Pharci::FILENAME_SETTINGS)===FALSE && strpos($args[Pharci::ATTRIBUTE_SRC], '.DS_Store')===FALSE && (!($args[Pharci::ATTRIBUTE_EVENT_TYPE]==Pharci::EVENT_TYPE_MODIFIED && $args[Pharci::ATTRIBUTE_OBJECT]==Pharci::EVENT_OBJECT_FOLDER))) { 

  // determine epoch
  $queue_file = Pharci::FILENAME_QUEUE_PREFIX.date(Pharci::FILENAME_QUEUE_SUFFIX, time());

  // update queue
  file_put_contents($queue_file, (file_exists($queue_file)?"\n":'').json_encode($args), FILE_APPEND);
}