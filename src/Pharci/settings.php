<?php 
// read $settings and extract contents into global namespace - TODO: think.
if(file_exists(Pharci\Pharci::FILENAME_SETTINGS)) extract(json_decode(file_get_contents(Pharci\Pharci::FILENAME_SETTINGS),true));