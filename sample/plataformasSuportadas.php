<?php 


$a = passthru('yt-dlp --list-extractors');

var_dump($a) or die();
