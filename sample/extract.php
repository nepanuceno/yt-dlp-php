<?php

use YtDpl\YtDplAudio;

require_once "../vendor/autoload.php";

header("Content-Type: application/json; charset=utf-8");
$data = json_decode(json: file_get_contents(filename: "php://input"), associative: true);
$url = $data["urlInput"] ?? null;
// $audioFormat = $data["audioFormat"] ?? null;

$objYtDlpMedia = new YtDplMedia();
$objYtDlpMedia->setPath(path: dirname(__DIR__) . "/file_temp");
$objYtDlpMedia->setUrl(url: $url);
$objYtDlpMedia->setPlaylist(playlist: true);

$fileName = $objYtDlpMedia->getMideaName($url);

$tempFileName = md5($fileName);

$objYtDlpMedia->setFileName(fileName: $tempFileName);

$objYtDlpAudio->generateFile();   

$daration = $objYtDlpAudio->extractInfoFile();

echo json_encode(array(
    "status" => true,
    "duracao" => $daration
));

?>
