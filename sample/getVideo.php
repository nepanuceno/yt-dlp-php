<?php 

require_once "../vendor/autoload.php";

use YtDpl\YtDlpVideo;

header("Content-Type: application/json; charset=utf-8");

$url = filter_input(INPUT_POST, 'urlInput', FILTER_VALIDATE_URL);

$objYtDlpVideo = new YtDlpVideo();
$objYtDlpVideo->setUrl($url);

$info = $objYtDlpVideo->getInfoMedia();
// var_dump($info) or die();


// $json = $objYtDlpVideo->parseFormatOutput($info);

// echo json_encode([
//     'info' => $json
// ]);
