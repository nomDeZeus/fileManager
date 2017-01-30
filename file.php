<?php
/**
 * Created by PhpStorm.
 * User: rgrisot
 * Date: 20/01/17
 * Time: 09:24
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
    <style>
        #drop-zone {
            /*Sort of important*/
            width: 300px;
            /*Sort of important*/
            height: 200px;
            margin: auto;
            border: 2px dashed rgba(0,0,0,.3);
            border-radius: 20px;
            font-family: Arial, serif;
            text-align: center;
            position: relative;
            line-height: 180px;
            font-size: 20px;
            color: rgba(0,0,0,.3);
        }

        #drop-zone input {
            /*Important*/
            position: absolute;
            /*Important*/
            cursor: pointer;
            left: 0;
            top: 0;
            /*Important This is only comment out for demonstration purposes.*/
            opacity:0;
        }

        /*Important*/
        #drop-zone.mouse-over {
            border: 2px dashed rgba(0,0,0,.5);
            color: rgba(0,0,0,.5);
        }


    /*If you dont want the button*/
        #clickHere {
            position: absolute;
            cursor: pointer;
            left: 50%;
            top: 50%;
            margin-left: -50px;
            margin-top: 20px;
            line-height: 26px;
            color: white;
            font-size: 12px;
            width: 100px;
            height: 26px;
            border-radius: 4px;
            background-color: #3b85c3;

        }

        #clickHere:hover {
            background-color: #4499DD;

        }
    </style>
</head>
<body>
<form action="posted_file.php" id="fileUpload" method="post">
    <div id="drop-zone">
        Drop files here...
        <div id="clickHere">
            or click here..
            <input type="file" name="files[]" id="file" multiple/>
        </div>
    </div>
    <input type="hidden" name="dir" value="<?php echo (isset($_GET['dir'])&&!empty($_GET['dir'])?$_GET['dir']:'.'); ?>">
    <output name="preview" for="file" form="fileUpload" id="preview"></output>
</form>


<script src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
<script>
    /*
    * drag and drop
    * */
    $(function dragNDrop() {
        var dropZoneId = "drop-zone";
        var buttonId = "clickHere";
        var mouseOverClass = "mouse-over";

        var dropZone = $("#" + dropZoneId);
        var ooleft = dropZone.offset().left;
        var ooright = dropZone.outerWidth() + ooleft;
        var ootop = dropZone.offset().top;
        var oobottom = dropZone.outerHeight() + ootop;
        var inputFile = dropZone.find("input");
        document.getElementById(dropZoneId).addEventListener("dragover", function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropZone.addClass(mouseOverClass);
            var x = e.pageX;
            var y = e.pageY;

            if (!(x < ooleft || x > ooright || y < ootop || y > oobottom)) {
                inputFile.offset({ top: y - 15, left: x - 100 });
            } else {
                inputFile.offset({ top: -400, left: -400 });
            }

        }, true);

        if (buttonId != "") {
            var clickZone = $("#" + buttonId);

            var oleft = clickZone.offset().left;
            var oright = clickZone.outerWidth() + oleft;
            var otop = clickZone.offset().top;
            var obottom = clickZone.outerHeight() + otop;

            clickZone.mousemove(function (e) {
                var x = e.pageX;
                var y = e.pageY;
                if (!(x < oleft || x > oright || y < otop || y > obottom)) {
                    inputFile.offset({ top: y - 15, left: x - 160 });
                } else {
                    inputFile.offset({ top: -400, left: -400 });
                }
            });
        }

        document.getElementById(dropZoneId).addEventListener("drop", function () {
            $("#" + dropZoneId).removeClass(mouseOverClass);
        }, true);

    });
    /*
    * Detect change
    * */
    $(function changeDetection() {
       $('input:file').change(function () {
            var $form = $("#fileUpload");
            var formdata = (window.FormData) ? new FormData($form[0]) : null;
            var data = (formdata !== null) ? formdata : $form.serialize();
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                dataType: "json",
                contentType: false,
                processData: false,
                data: data,
                success: function (response) {
                    alert('Files uploaded');
                    parent.closeAndRefresh();
                }
            });
       });
    });
    /*
    * file preview
    * */
    $(function preview() {
       if (window.File && window.FileList && window.FileReader){
           var filesInput = $("#file");
           filesInput.on('change', function (event) {
               var files = event.target.files;
               var output = $("#preview");
               for (var i = 0; i < files.length; i++){
                   var file = files[i];
                   if (!file.type.match('image')){
                       continue;
                   }
                   var picReader = new FileReader();
                   picReader.addEventListener('load', function (event) {
                       var picFile = event.target;
                       output.append("<img class='thumbnail' src='" + picFile.result + "'>")
                   });
                   picReader.readAsDataURL(file);
               }
           });
       }
       else{
           console.log("Your browser does not support file API");
       }
    });
</script>

</body>
</html>
