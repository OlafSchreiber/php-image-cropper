<?php
/**
 * Created by PhpStorm.
 * User: Olaf
 * Date: 25.10.2014
 * Time: 09:46
 */

session_start();

$show_w = 600;

$aspectRatio = 1.5;
$targ_w = 300;
$targ_h = $targ_w/$aspectRatio;
$jpeg_quality = 85;
$folder = 'images/';
$appendToFilename = '_cropped';