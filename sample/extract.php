<?php

require_once '../vendor/autoload.php';

use YtDpl\YtDplAudio;

$data = json_decode(file_get_contents("php://input"), true);
$url = $data["urlInput"];

$objYtDlpAudio = new YtDplAudio();
$objYtDlpAudio->setPath('/var/www/file_temp');
$objYtDlpAudio->setUrl($url);
$objYtDlpAudio->setPlaylist(true);
$objYtDlpAudio->setAudioFormat('mp3');
$objYtDlpAudio->setNameFile('teste');
$objYtDlpAudio->download();
?>