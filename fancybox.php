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
</head>
<body>

    <h1>File Manager</h1>
    <section>
        <header>
            <h1>Select File...</h1>
            <nav>
                <?php
                echo $printed.'/';
                ?>
                <ul>
                    <li><a href="./mkdir.php?iframe&dir=<?php echo $requestedDir; ?>" id="folder">Create folder</a></li>
                    <li><a href="">Refresh</a></li>
                    <li><a href="./file.php?iframe" id="file">Add file</a></li>
                </ul>
            </nav>
        </header>
        <?php
            foreach ($dirs as $dir){
                ?>
                <div class="<?php echo (is_dir($currentDir.'/'.$dir)?'dir':'file'); ?>">
                    <a href="./fancybox.php?dir=<?php echo $printed.'/'.$dir; ?>">
                        <?php
                            echo ($dir == '..')?'parent':$dir;
                        ?>
                    </a>
                </div>
                <?php
            }
        ?>
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
