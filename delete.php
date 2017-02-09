<?php
/**
 * Created by PhpStorm.
 * User: rgrisot
 * Date: 03/02/17
 * Time: 14:03
 */
require_once ('includes/dir.php');
require_once ('includes/const.php');

$dirname = filter_input(INPUT_GET, 'dirname', FILTER_SANITIZE_MAGIC_QUOTES);
if($dirname === null or $dirname === false or empty($dirname)){
    exit;
}
$baseDir = realpath($uploadDir);
$requestedDir = (isset($_GET['dir'])?$_GET['dir']:'');
if(!($currentDir = dir_is_valid($requestedDir, $baseDir))){
    header('HTTP/1.1 403 Error : Directory traversal');
    exit;
}
if(strpos(realpath($currentDir.'/'.$dirname), $baseDir) !== 0 || realpath($currentDir.'/'.$dirname) == $baseDir){
    header('HTTP/1.1 403 Error : Wrong folder name');
    exit;
}
if(is_dir($currentDir.'/'.$dirname)){
    rmdir($currentDir.'/'.$dirname);
}
else if(file_exists($currentDir.'/'.$dirname)){
    unlink($currentDir.'/'.$dirname);
}else{
    header('HTTP/1.1 404 Error : File does not exist');
}