<?php
/**
 * Created by PhpStorm.
 * User: rgrisot
 * Date: 03/02/17
 * Time: 14:03
 */
require_once ('includes/dir.php');
require_once ('includes/const.php');

$dirname = filter_input(INPUT_GET, 'dir', FILTER_SANITIZE_MAGIC_QUOTES);
if($dirname === null or $dirname === false or empty($dirname)){
    exit;
}
$baseDir = realpath($uploadDir);
$deletePath = realpath($baseDir.'/'.$dirname);
if(!dir_is_valid($dirname)){
    header('HTTP/1.1 403 Error : Directory traversal');
    exit;
}
if(realpath($deletePath) == $baseDir){
    header('HTTP/1.1 403 Error : Wrong folder name');
    exit;
}
if(is_dir($deletePath)){
    rrmdir($deletePath);
}
else if(file_exists($deletePath)){
    unlink($deletePath);
}else{
    header('HTTP/1.1 404 Error : File does not exist');
}


function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir."/".$object)) rrmdir($dir."/".$object); else unlink($dir."/".$object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}





/*$dirname = filter_input(INPUT_GET, 'dir', FILTER_SANITIZE_MAGIC_QUOTES);
if($dirname === null or $dirname === false or empty($dirname)){
    exit;
}
$baseDir = realpath($uploadDir);
if(!($currentDir = dir_is_valid($dirname, $baseDir))){
    header('HTTP/1.1 403 Error : Directory traversal');
    exit;
}
if(strpos(realpath($currentDir), $baseDir) !== 0 || realpath($currentDir) == $baseDir){
    header('HTTP/1.1 403 Error : Wrong folder name');
    exit;
}
if(is_dir($currentDir)){
    rmdir($currentDir);
}
else if(file_exists($currentDir)){
    unlink($currentDir);
}else{
    header('HTTP/1.1 404 Error : File does not exist');
}*/