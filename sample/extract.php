<?php

use YtDpl\YtDplMedia;

require_once "../vendor/autoload.php";

header("Content-Type: application/json; charset=utf-8");
$data = json_decode(json: file_get_contents(filename: "php://input"), associative: true);
$url = $data["urlInput"] ?? null;

$objYtDlpMedia = new YtDplMedia();
$objYtDlpMedia->setPath(path: dirname(__DIR__) . "/file_temp");
$objYtDlpMedia->setUrl(url: $url);
$objYtDlpMedia->setPlaylist(playlist: true);

$fileName = $objYtDlpMedia->getMideaName();

$tempFileName = md5($fileName);

$objYtDlpMedia->setFileName(fileName: $tempFileName);

$daration = $objYtDlpMedia->getDurationMedia();

echo json_encode(array(
    "status" => true,
    "duracao" => $daration
));

?>
