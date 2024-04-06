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
function nestedToNormal($arr)
{
    $res = [];
    foreach ($arr as $key => $value) {
        if (is_array($value)) {
            $tmp_res = mergePrefixWithArray($key, $value);
            $res = array_merge($tmp_res, $res);
        } else {
            $res[$key] = $value;
        }
    }
    return $res;
}

function mergePrefixWithArray($prefix, $arr)
{
    $res = [];
    foreach ($arr as $key => $value) {
        if (is_array($value)) {
            $tmp_res = mergePrefixWithArray($key, $value);
            $res = array_merge($tmp_res, $res);
        } else {
            $res[$prefix . '.' . $key] = $value;
        }
    }
    return $res;
}
        