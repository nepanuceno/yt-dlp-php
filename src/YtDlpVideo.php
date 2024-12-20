<?php
namespace YtDpl;

class YtDlpVideo extends YtDpl
{
    public function getInfoMedia()
    {        
        return passthru('yt-dlp -F '. $this->getUrl());
    }
}