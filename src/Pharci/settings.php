<?php 
// path to settings
$settings = 'settings.json'; 

// read $settings and extract contents into global namespace (TODO: think.)
if(file_exists($settings)) extract(json_decode(file_get_contents($settings),true));