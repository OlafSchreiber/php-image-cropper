<?php
/**
 * Created by PhpStorm.
 * User: Olaf
 * Date: 25.10.2014
 * Time: 10:34
 */
require_once('config.inc.php');
require_once('functions.php');

?>
<!DOCTYPE html >
<html lang="de">
<head>
    <title> Cropper</title>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
    <link rel="stylesheet" href="css/main.css" type="text/css"/>
    <style type="text/css">
        #dwrap div {
            width: <?php echo $targ_w; ?>px;
            height: <?php echo 2.5 * $targ_h; ?>px;
            max-height: <?php echo 2.5 * $targ_h; ?>px;
            border: 1px solid #000;
            float: left;
            overflow: hidden;
            padding: 10px;
            margin: 10px;;
        }
    </style>

</head>
<body>

<div id="dwrap">
    <?php

    $files = scandir($folder);

    foreach ($files as $file) {
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        //TODO For now only jpg  || $extension == 'gif' || $extension == 'png' || $extension == 'jpeg')
        if ($extension == 'jpg') {

            if (!IsCroppedFileName($appendToFilename, $file)) {
                echo '<div style="font-size: 0.8em;">' . $file . '<br /><a href="cropper.php?f=' . $file . '"><img src="' . $folder . $file . '" style="width:' . $targ_w . 'px" /></a>';
                $croppedFilename = GetCroppedFileName($appendToFilename, $file);
                if (file_exists($folder . $croppedFilename)) {
                    echo '<br /><img src="' . $folder . $croppedFilename . '" />';
                } else {
                    echo '<span style="color:red; font-weight:bold;">Muss noch gecroppt werden!</span>';
                }
                echo '</div>';
            }
        }
    }

    ?>
</div>
</body>
</html>