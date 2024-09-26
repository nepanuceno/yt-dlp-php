<?php

require_once '../vendor/autoload.php';
use YtDpl\YtDplAudio;


$objYtDlpAudio = new YtDplAudio();
$objYtDlpAudio->setPath('/var/www/file_temp');
$objYtDlpAudio->setUrl('https://www.youtube.com/watch?v=uIh8JmGJYEk');
$objYtDlpAudio->setPlaylist(true);
$objYtDlpAudio->setAudioFormat('mp3');
$objYtDlpAudio->download();
