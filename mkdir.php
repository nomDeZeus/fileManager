<?php
/**
 * Created by PhpStorm.
 * User: rgrisot
 * Date: 16/01/17
 * Time: 16:46
 */

require_once ('includes/dir.php');
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/fancy.css">
</head>
<body>
<?php
if(!isset($_POST['dirname'])) {
    $dir = (isset($_GET['dir'])?$_GET['dir']:'');
?>
    <form action="" method="post">
        <p>
            <label for="dirname">Nom du dossier : </label>
            <input type="text" name="dirname" id="dirname">
            <input type="hidden" name="dir" value="<?php echo $dir; ?>">
            <input class="btn btn-primary btn-circle" type="submit" value="Créer">
        </p>
    </form>
<?php
} else{
    $dirname = filter_input(INPUT_POST, 'dirname', FILTER_SANITIZE_MAGIC_QUOTES);
    if($dirname === null or $dirname === false){
        exit;
    }
    if(empty($dirname)){
        $dirname = ".";
    }

    $baseDir = realpath('uploads');
    $requestedDir = (isset($_POST['dir'])?$_POST['dir']:'');
    if(!($currentDir = dir_is_valid($requestedDir, $baseDir))){
        exit;
    }
    set_error_handler(function() { /* ignore errors */echo 'Erreur lors de la creation. Verifiez les doublons'; exit; });
    $create = mkdir($currentDir.'/'.$dirname);
    restore_error_handler();

    if(strpos(realpath($currentDir.'/'.$dirname), $baseDir) !== 0){
        echo 'Erreur lors de la creation. Verifiez les doublons';
        unlink($currentDir.'/'.$dirname);
        exit;
    }

    ?>
    <script type="text/javascript">
        //parent.$.fancybox.close();
        parent.closeAndRefresh();
    </script>
<?php
}
?>
</body>
</html>

