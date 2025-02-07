<?php

require_once "../vendor/autoload.php";

use YtDpl\YtDplMedia;

header("Content-Type: application/json; charset=utf-8");

$data = json_decode(json: file_get_contents(filename: "php://input"), associative: true);

$url = $data["urlInput"] ?? null;

$audioFormat = $data["extension"];
$id = $data["videoFormat"] ?? 'm4a';

$objYtDlpMedia = new YtDplMedia();
$objYtDlpMedia->setPath(path: dirname(__DIR__) . "/file_temp");
$objYtDlpMedia->setUrl(url: $url);
$objYtDlpMedia->setIdOptionMedia($audioFormat);
$objYtDlpMedia->setAudioFormat(audioFormat: $audioFormat);
$objYtDlpMedia->setIdOptionMedia($id);

$fileName = $objYtDlpMedia->getMideaName();

$objYtDlpMedia->setFileName(fileName: $fileName);
$objYtDlpMedia->setFileTempName();

$minValueDisplay = $data["minValueDisplay"];
$maxValueDisplay = $data["maxValueDisplay"];

$objYtDlpMedia->generateFile();

$objYtDlpMedia->cutFile($minValueDisplay, $maxValueDisplay, $fileName);
$objYtDlpMedia->download($objYtDlpMedia->getFileNameFormated());
