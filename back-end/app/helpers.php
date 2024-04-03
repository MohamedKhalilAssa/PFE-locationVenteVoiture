<?php

function includeAllFiles($path)
{
    // Specify the folder path
    $folder = base_path() . $path;

    // Get an array of file paths in the folder
    $files = glob($folder . '*');
    // Loop through each file and include it
    foreach ($files as $file) {
        include_once $file;
    }
}
