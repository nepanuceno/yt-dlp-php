<?php 

require_once "../vendor/autoload.php";

use YtDpl\YtDplAudio;

header("Content-Type: application/json; charset=utf-8");

$data = json_decode(json: file_get_contents(filename: "php://input"), associative: true);

$url = $data["urlInput"] ?? null;

$objYtDlpAudio = new YtDplAudio();
$fileName = $objYtDlpAudio->getMideaName($url);


$minValueDisplay = $data["minValueDisplay"];
$maxValueDisplay = $data["maxValueDisplay"];    
$objResponse = $objYtDlpAudio->cutFile($minValueDisplay, $maxValueDisplay, $fileName);    
$objYtDlpAudio->download($fileName);
