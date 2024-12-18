<?php

require_once "../vendor/autoload.php";

use YtDpl\YtDplAudio;

header("Content-Type: application/json; charset=utf-8");
$data = json_decode(json: file_get_contents(filename: "php://input"), associative: true);
$url = $data["urlInput"] ?? null;
$download = $data['download'] ?? null;

$objYtDlpAudio = new YtDplAudio();
$objYtDlpAudio->setPath(path: dirname(__DIR__) . "/file_temp");
$objYtDlpAudio->setUrl(url: $url);
$objYtDlpAudio->setPlaylist(playlist: true);
$objYtDlpAudio->setAudioFormat(audioFormat: "mp3");

$fileName = $objYtDlpAudio->getMideaName($url);

$objYtDlpAudio->setNameFile(nameFile: $fileName);

if(!$download) {
    $objYtDlpAudio->extractFile();    
    $daration = $objYtDlpAudio->extractInfoFile();
    echo json_encode(array(
        "status" => true,
        "duracao" => $daration,
    ));
} else {
    $minValueDisplay = $data["minValueDisplay"];
    $maxValueDisplay = $data["maxValueDisplay"];    
    $objResponse = $objYtDlpAudio->cutFile($minValueDisplay, $maxValueDisplay, $fileName);
    $objYtDlpAudio->download($fileName);

    // echo $objResponse;
}
?>
