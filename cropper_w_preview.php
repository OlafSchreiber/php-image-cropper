<?php

//TODO So far getting the right coordinates failed
/* The resizing of the rendered image is the problem. I need to be fresh to fix this.
Need to calculate the ratio between the real image size and the output image size.
 */

require_once('config.inc.php');
require_once('functions.php');

$fileToCrop = isset($_GET['f']) ? $_GET['f'] : (isset($_SESSION['file']) ? $_SESSION['file'] : '');

$_SESSION['file'] = $fileToCrop;
$src = $folder . $fileToCrop;
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $img_r = imagecreatefromjpeg($src);
    $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

    #echo $_POST['x'] .'<br>', $_POST['y'] . '<br>', $targ_w . '<br>', $targ_h . '<br>', $_POST['w'] . '<br>', $_POST['h'] . '<br>';
    imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);

    $saveName = GetCroppedFileName($appendToFilename, $fileToCrop);
    imagejpeg($dst_r, $folder . $saveName, $jpeg_quality);

    header('location:index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>Cropper</title>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.Jcrop.js"></script>
    <link rel="stylesheet" href="css/main.css" type="text/css"/>
    <link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css"/>

    <script type="text/javascript">

        jQuery(function ($) {

            var imageWidth, imageHeight;
            var img = document.getElementsByTagName("img")[0];
            img.onload = function () {
                imageWidth = img.naturalWidth;
            }

            // Create variables (in this scope) to hold the API and image size
            var jcrop_api,
                boundx,
                boundy,

            // Grab some information about the preview pane
                $preview = $('#preview-pane'),
                $pcnt = $('#preview-pane .preview-container'),
                $pimg = $('#preview-pane .preview-container img'),

                xsize = $pcnt.width(),
                ysize = $pcnt.height();

            //console.log('init', [xsize, ysize]);
            $('#target').Jcrop({
                onChange: updatePreview,
                onSelect: updatePreview,
                aspectRatio: xsize / ysize
            }, function () {
                // Use the API to get the real image size
                var bounds = this.getBounds();
                boundx = bounds[0];
                boundy = bounds[1];
                // Store the API in the jcrop_api variable
                jcrop_api = this;

                // Move the preview into the jcrop container for css positioning
                $preview.appendTo(jcrop_api.ui.holder);
            });

            function updatePreview(c) {
                if (parseInt(c.w) > 0) {
                    var rx = xsize / c.w;
                    var ry = ysize / c.h;

                    console.log('coords', [c.x, c.y, c.w, c.h, boundx]);

                    $pimg.css({
                        width: Math.round(rx * boundx) + 'px',
                        height: Math.round(ry * boundy) + 'px',
                        marginLeft: '-' + Math.round(rx * c.x) + 'px',
                        marginTop: '-' + Math.round(ry * c.y) + 'px'
                    });
//                    $('#x').val(c.x);
//                    $('#y').val(c.y);
//                    $('#w').val(c.w);
//                    $('#h').val(c.h);

                    var factor = imageWidth / <?php echo $show_w; ?>;
                    $('#x').val(Math.round(c.x * factor));
                    $('#y').val(Math.round(c.y * factor));
                    $('#w').val(Math.round(c.w * factor));
                    $('#h').val(Math.round(c.h * factor));
                }
            };
        });


        function checkCoords() {
            if (parseInt($('#w').val())) return true;
            alert('Bitte eine Region mit der Maus auswählen!');
            return false;
        }

    </script>

    <style type="text/css">
        #target {
            background-color: #ccc;
            font-size: 24px;
            display: block;
            width: <?php echo $show_w; ?>px;
        }

        #preview-pane .preview-container {
            width: <?php echo $targ_w; ?>px;
            height: <?php echo $targ_h; ?>px;
            overflow: hidden;
        }

        /* Apply these styles only when #preview-pane has
           been placed within the Jcrop widget */
        .jcrop-holder #preview-pane {
            display: block;
            position: absolute;
            z-index: 2000;
            top: 10px;
            right: -<?php echo $targ_w + 30; ?>px;
            padding: 0px;
            border: 1px rgba(0, 0, 0, .4) solid;
            background-color: white;
        }
    </style>

</head>
<body>
<h2>Bild croppen</h2>
<?php echo $message; ?><br/>
<a href="index.php">Zurück</a><br/>

<div class="container">

    <!-- This is the image we're attaching Jcrop to -->
    <img src="<?php echo $src; ?>" id="target"/>

    <div id="preview-pane">
        <div class="preview-container">
            <img src="<?php echo $src; ?>" class="jcrop-preview" alt="Preview"/>
        </div>
    </div>

    <!-- This is the form that our event handler fills -->
    <form action="" method="post" onsubmit="return checkCoords();">
        <input type="hidden" id="x" name="x"/>
        <input type="hidden" id="y" name="y"/>
        <input type="hidden" id="w" name="w"/>
        <input type="hidden" id="h" name="h"/>
        <input type="submit" value="Bild croppen" class="btn btn-large btn-inverse"/>
    </form>

</div>
</body>

</html>
