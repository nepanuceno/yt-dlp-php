<?php 

require_once "../vendor/autoload.php";

use YtDpl\YtDplMedia;

header("Content-Type: application/json; charset=utf-8");

$url = filter_input(INPUT_POST, 'urlInput', FILTER_VALIDATE_URL);

$objYtDplMedia = new YtDplMedia();
$objYtDplMedia->setUrl($url);
$objYtDplMedia->getInfoMedia();

