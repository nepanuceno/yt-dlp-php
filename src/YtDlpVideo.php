<?php
namespace YtDpl;

class YtDlpVideo extends YtDpl
{
    public function getInfoMedia(): void
    {        
        passthru('yt-dlp -F '. $this->getUrl());
    }
}