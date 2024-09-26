<?php
namespace YtDpl;

class YtDplAudio
{
    public $playList;
    public $audioFormat;
    public $url;

    public function __construct(){}

    public function setPlayList($playList)
    {
        $this->playList = $playList;
    }

    public function setAudioFormat($audioFormat)
    {
        $this->audioFormat = $audioFormat;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function download()
    {
        $cmd = "yt-dlp --yes-playlist -x --audio-format mp3 https://www.youtube.com/watch?v=uIh8JmGJYEk";
        system($cmd);
    }
}