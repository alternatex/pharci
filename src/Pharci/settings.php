<?php 
// path to settings
$settings = 'settings.json'; 

// read $settings and extract it's contents as variables *bazinga* 
if(file_exists($settings)) extract(json_decode(file_get_contents($settings),true)); else die("ERROR: settings.json not found.");