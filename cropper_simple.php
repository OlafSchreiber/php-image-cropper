<?php
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

        $(function () {

            $('#cropbox').Jcrop({
                aspectRatio: 1.5,
                onSelect: updateCoords
            });

        });

        function updateCoords(c) {
            $('#x').val(c.x);
            $('#y').val(c.y);
            $('#w').val(c.w);
            $('#h').val(c.h);
        }

        function checkCoords() {
            if (parseInt($('#w').val())) return true;
            alert('Bitte eine Region auswählen.');
            return false;
        }


    </script>

</head>
<body>
<h2>Bild croppen</h2>
<?php echo $message; ?><br/>
<a href="index.php">Zurück</a><br/>

<div class="container">
    <!-- This is the image we're attaching Jcrop to -->
    <img src="<?php echo $src; ?>" id="cropbox"/>

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
