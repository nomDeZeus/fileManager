<?php
/**
 * Created by PhpStorm.
 * User: rgrisot
 * Date: 18/01/17
 * Time: 10:08
 */
function dir_is_valid($requestedDir, $baseDir){
    $requestedDir='uploads/'.$requestedDir;
    $currentDir = realpath($requestedDir);
    if($currentDir == false || strpos($currentDir, $baseDir) !== 0){
        echo 'Directory traversal';
        return false;
    }
    return $currentDir;
}