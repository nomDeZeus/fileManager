<?php
/**
 * Created by PhpStorm.
 * User: rgrisot
 * Date: 16/01/17
 * Time: 15:14
 */
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
<a id="iframe" href="./fancybox.php">Lien vers une iframe</a>
<input type="text" id="image">

<script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="js/uploader.js"></script>
<script>
$(document).ready(function() {
    var uploader = new Uploader("image");
    $("#iframe").fancybox({
        'fitToView'         : false,
        'width'             : '75%',
        'height'            : '80%',
        'autoScale'         : false,
        'autoSize'          : false,
        'transitionIn'      : 'elastic',
        'transitionOut'     : 'elastic',
        'type'              : 'iframe'
    });
});
</script>

</body>
</html>
