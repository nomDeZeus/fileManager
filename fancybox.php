<?php
/**
 * Created by PhpStorm.
 * User: rgrisot
 * Date: 16/01/17
 * Time: 15:49
 */
require_once ('includes/dir.php');
require_once ('includes/const.php');
function pathFromUploadRoot($pathArray, $index){
    if(count($pathArray) <= $index){
        return false;
    }
    $path = '';
    for($i = 0; $i <= $index; $i++){
        $path.=($pathArray[$i].'/');
    }
    return $path;
}
$baseDir = realpath($uploadDir);
$requestedDir = (isset($_GET['dir'])?$_GET['dir']:'');
if(!($currentDir = dir_is_valid($requestedDir, $baseDir))){
    exit;
}
$arr = explode(realpath($uploadDir), $currentDir);
$printed = ($arr[1] == '')?'.':$arr[1];
$explodedPath = explode('/', $printed);

$dirs = scandir($currentDir);
if($baseDir === $currentDir){
    array_splice($dirs, 0, 2);
}else{
    array_splice($dirs, 0, 1);
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lemonada" rel="stylesheet">
    <link rel="stylesheet" href="fancybox/source/jquery.fancybox.css">
    <link rel="stylesheet" href="css/fancy.css">
</head>
<body>

    <div id="header">
        <h1 id="title">File Manager</h1>
        <div id="icone">
            <table>
                <tr>
                    <td>
                        <a href="./mkdir.php?iframe&dir=<?php echo $requestedDir; ?>" id="folder">
                            <img src="img/New-Folder.png" alt="Creer un dossier" title="Cliquez pour créer un dossier" height="40" width="40"/>
                        </a>
                    </td>
                    <td>
                        <a href="">
                            <img src="img/refresh.png" alt="Rafraichir" title="Cliquez pour raffraichir" height="40" width="40"/>
                        </a>
                    </td>
                    <td>
                        <a href="./file.php?iframe&dir=<?php echo $requestedDir; ?>" id="file">
                            <img src="img/New-File.png" alt="Rajouter un fichier" title="Cliquez pour rajouter un fichier" height="40" width="40"/>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <section>
        <header>
            <h1>Choisir un fichier déjà importé:</h1>
            <nav><i>
                <?php
                //echo $printed.'/';
                //var_dump($explodedPath);
                foreach ($explodedPath as $key => $value){
                    //var_dump(pathFromUploadRoot($explodedPath, $key));
                    ?>
                    <a href="./fancybox.php?dir=<?php echo pathFromUploadRoot($explodedPath, $key); ?>"><?php echo $value; ?></a>
                    <?php if($key !== count($explodedPath) - 1 && $key !== 0){ echo '>'; } ?>
                    <?php
                }
                ?>
                </i></nav>
        </header>
        <ul>
            <?php
                foreach ($dirs as $dir){
                    ?>
            <li>
                <a href="blank" class="boxclose"></a>
                <a href="./fancybox.php?dir=<?php echo $printed.'/'.$dir; ?>" title="<?php echo $dir; ?>" data-path="<?php echo $uploadDir.'/'.substr(getRelativePath($baseDir, $currentDir.'/'.$dir), 2); ?>">
                    <div class="<?php if($dir == '..') echo 'parent';else echo (is_dir($currentDir.'/'.$dir)?'dir':'file'); ?>"></div>
                    <div class="descr-ico"><?php echo ($dir == '..')?'parent':$dir; ?>
                    </div>
                </a>
            </li>
                    <?php
                }
            ?>
        </ul>
    </section>


<script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous">
</script>
<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="js/uploader.js"></script>
<script>
$(document).ready(function() {
    $("#folder").fancybox({
        'fitToView'         : false,
        'width'             : '50%',
        'height'            : '10%',
        'autoScale'         : false,
        'autoSize'          : false,
        'transitionIn'      : 'elastic',
        'transitionOut'     : 'elastic',
        'type'              : 'iframe'
    });
    $("#file").fancybox({
        'fitToView'         : false,
        'width'             : '50%',
        'height'            : '60%',
        'autoScale'         : false,
        'autoSize'          : false,
        'transitionIn'      : 'elastic',
        'transitionOut'     : 'elastic',
        'type'              : 'iframe'
    });
});
function closeAndRefresh(){
    $.fancybox.close();
    location.reload();
}

$(".file").on('click', function (e) {
    e.preventDefault();
    fillInput($(this));
});
$(".descr-ico").on('click', function (e) {
    if($(this).prev().hasClass('file')){
        e.preventDefault();
        fillInput($(this));
    }

});
function fillInput(obj){
    var uploader = new Uploader();
    $('#'+uploader.idInput, window.parent.document).val(obj.parent().attr('data-path'));
}
</script>
</body>
</html>
