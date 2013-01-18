<?php 
// path to settings // TODO: ensure relative to cwd
$settings = 'settings.json'; 

// read $settings and extract contents into global namespace (TODO: think.)
if(file_exists($settings)) extract(json_decode(file_get_contents($settings),true)); else die("ERROR: settings.json not found.");