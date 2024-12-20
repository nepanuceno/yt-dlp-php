<?php

require_once "../vendor/autoload.php";

use YtDpl\YtDplAudio;

header("Content-Type: application/json; charset=utf-8");
$data = json_decode(json: file_get_contents(filename: "php://input"), associative: true);
$url = $data["urlInput"] ?? null;
$audioFormat = $data["audioFormat"] ?? null;

$objYtDlpAudio = new YtDplAudio();
$objYtDlpAudio->setPath(path: dirname(__DIR__) . "/file_temp");
$objYtDlpAudio->setUrl(url: $url);
$objYtDlpAudio->setPlaylist(playlist: true);
$objYtDlpAudio->setAudioFormat(audioFormat: $audioFormat);

$fileName = $objYtDlpAudio->getMideaName($url);

$tempFileName = md5($fileName);

$objYtDlpAudio->setFileName(fileName: $tempFileName);

$objYtDlpAudio->generateFile();    

$daration = $objYtDlpAudio->extractInfoFile();

echo json_encode(array(
    "status" => true,
    "duracao" => $daration,
));

?>
