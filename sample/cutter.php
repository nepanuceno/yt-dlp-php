<?php

require_once "../vendor/autoload.php";

use YtDpl\YtDplAudio;

header("Content-Type: application/json; charset=utf-8");

$data = json_decode(json: file_get_contents(filename: "php://input"), associative: true);

$url = $data["urlInput"] ?? null;
$audioFormat = $data["audioFormat"];

$objYtDlpAudio = new YtDplAudio();
$objYtDlpAudio->setPath(path: dirname(__DIR__) . "/file_temp");
$objYtDlpAudio->setAudioFormat(audioFormat: $audioFormat);
$fileName = $objYtDlpAudio->getMideaName($url);
$tempFileName = md5($fileName);

$objYtDlpAudio->setFileName(fileName: $tempFileName);



$minValueDisplay = $data["minValueDisplay"];
$maxValueDisplay = $data["maxValueDisplay"];

$objYtDlpAudio->cutFile($minValueDisplay, $maxValueDisplay, $fileName);    
$objYtDlpAudio->download($fileName);
