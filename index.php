<?php
/**
 * Created by PhpStorm.
 * User: Olaf
 * Date: 25.10.2014
 * Time: 10:34
 */
 require_once('config.inc.php');


?>
<!DOCTYPE html >
<html lang = "de" >
<head >
    <title > Cropper</title >
    <meta http - equiv = "Content-type" content = "text/html;charset=UTF-8" />
    </head>
<body>
<?php

$files = scandir($folder);

foreach($files as $file) {
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if($extension == 'jpg' || $extension == 'gif' || $extension == 'png' || $extension == 'jpeg') {
        echo '<a href="cropper.php?f=' . $file . '"><img src="'. $folder . $file . '" style="width:' . $targ_w . 'px"><br />' . $file . '<br />';
    }
}

?>
</body>
</html>