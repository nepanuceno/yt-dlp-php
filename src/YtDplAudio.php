<?php
namespace YtDpl;

use YtDpl\Interfaces\YtDplAudioInterface;

class YtDplAudio extends YtDpl implements YtDplAudioInterface
{
    public $audioFormat;

    public function __construct(){}

    public function setAudioFormat($audioFormat)
    {
        $this->audioFormat = $audioFormat;
    }

    public function getAudioFormat()
    {
        return $this->audioFormat;
    }
	
    public function download()
    {
        system($this->buildCommand());
    }

    public function buildCommand()
    {
        return "./yt-dlp ".$this->getPlaylist()." -x --audio-format " . $this->getAudioFormat() . " " . $this->getPath() . " " . $this->getUrl();
    }   
}