<?php
/**
 * Created by PhpStorm.
 * User: Olaf
 * Date: 25.10.2014
 * Time: 15:51
 */
function GetCroppedFileName($appendToFilename, $filename) {
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    return str_replace(".$extension", "$appendToFilename.$extension", $filename);
}

function IsCroppedFileName($appendToFilename, $filename) {
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    return EndsWith($filename, "$appendToFilename.$extension");
}

function EndsWith($haystack, $needle)
{
    return $needle === '' || substr($haystack, -strlen($needle)) === $needle;
}