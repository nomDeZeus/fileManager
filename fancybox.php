<?php
/**
 * Created by PhpStorm.
 * User: rgrisot
 * Date: 16/01/17
 * Time: 15:49
 */
require_once ('includes/dir.php');
$baseDir = realpath('uploads');
$requestedDir = (isset($_GET['dir'])?$_GET['dir']:'');
if(!($currentDir = dir_is_valid($requestedDir, $baseDir))){
    exit;
}
$arr = explode(realpath('uploads'), $currentDir);
$printed = ($arr[1] == '')?'.':$arr[1];

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
    <link rel="stylesheet" href="fancybox/source/jquery.fancybox.css">
    <link rel="stylesheet" href="css/fancy.css">
</head>
<body>

    <div id="header">
        <h1 id="title">File Manager</h1>
        <div id="icone">
            <ul>
                <li>
                    <a href="./mkdir.php?iframe&dir=<?php echo $requestedDir; ?>" id="folder">
                        <img src="img/New-Folder.png" alt="Create Folder" title="Cliquez pour créer un dossier" />
                    </a>
                </li>
                <li><a href="">
                        <img src="img/refresh.png" alt="Refresh" title="Cliquez pour raffraichir" />
                    </a>
                </li>
                <li><a href="./file.php?iframe&dir=<?php echo $requestedDir; ?>" id="file">
                        <img src="img/New-File.png" alt="Create File" title="Cliquez pour créer un fichier" />
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <section>
        <header>
            <h1>Select File...</h1>
            <nav>
                <?php
                echo $printed.'/';
                ?>
            </nav>
        </header>
        <ul>
            <?php
                foreach ($dirs as $dir){
                    ?>
            <li>
                <a href="./fancybox.php?dir=<?php echo $printed.'/'.$dir; ?>" title="<?php echo $dir; ?>">
                    <div class="<?php if($dir == '..') echo 'parent';else echo (is_dir($currentDir.'/'.$dir)?'dir':'file'); ?>"></div>
                    <div class="descr-ico">
                        <?php
                        echo ($dir == '..')?'parent':$dir;
                        ?>
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
</script>
</body>
</html>
