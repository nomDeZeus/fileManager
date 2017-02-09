<?php
/**
 * Created by PhpStorm.
 * User: rgrisot
 * Date: 20/01/17
 * Time: 14:54
 */
require_once 'includes/const.php';
/**
 * removeError
 * Supprime les fichiers à l'index donné
 * @param $tab (array) tableau contenant l'erreur
 * @param $index (int) indice de l'erreur
 */
function removeError(&$tab, $index){
    foreach ($tab as $item){
        unset($item[$index]);
    }
}
$currentDir = filter_input(INPUT_POST, 'dir', FILTER_SANITIZE_STRING);
if($currentDir == null or $currentDir == false){
    header('HTTP/1.1 500 Directory Error');
    exit();
}
if(realpath($uploadDir.'/'.$currentDir) == false or strpos(realpath($uploadDir.'/'.$currentDir), realpath($uploadDir)) !== 0){
    header('HTTP/1.1 403 File Name Error');
    exit();
}
$files = $_FILES['files'];
$errors = array();

foreach ($files['error'] as $key => $error){
    /*
     * Erreur dans le fichier uploadé
     * */
    if ($error !== 0){
        //array_push($error, $files['name'][$key]);
        $errors[$files['name'][$key]] = 'File error';
        removeError($tab, $key);
        header('HTTP/1.1 500 File Error');
    }
}
$size = 0;
foreach ($files['size'] as $key => $f_size){
    /*
     * Taille totale trop importante
     */
    if(($size+=$f_size) > $MAX_SIZE){
        header('HTTP/1.1 500 File Size Error');
        exit();
    }
}
foreach ($files['tmp_name'] as $key => $tmp_name){
    $name = $files['name'][$key];
    if(file_exists($uploadDir.'/'.$currentDir.'/'.$name)){
        header('HTTP/1.1 500 Upload Error : File already exists');
        $errors[$files['name'][$key]] = 'File already exists';
        //array_push($error, $files['name'][$key]);
    }
    else if(!move_uploaded_file($tmp_name, $uploadDir.'/'.$currentDir.'/'.$name)){
        header('HTTP/1.1 500 Upload Error');
        $errors[$files['name'][$key]] = 'File cannot be uploaded';
        //array_push($error, $files['name'][$key]);
    }
}

header('Content-Type: application/json');
if(count($errors) == 0){
    header('HTTP/1.1 201 Files Uploaded');
}
echo json_encode($errors);//réponse contenant les erreurs