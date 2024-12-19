<?php
 namespace YtDpl;

 class YtDpl
 {
    public $url;
    public $path;
    public $playlist;
    public $writeDescription;
    public $writeComments;
    public $writeThumbnail;
    public $writeLink;
    public $nameFile;
    public $nameMidea;
    public $audioFormat;
    public $fileName;

    public function __construct(){}

    public function setUrl( $url): void {$this->url = $url;}

	public function setPath( $path): void {$this->path = $path;}

	public function setPlaylist( $playlist): void {$this->playlist = $playlist;}

	public function setWriteDescription( $writeDescription): void {$this->writeDescription = $writeDescription;}

	public function setWriteComments( $writeComments): void {$this->writeComments = $writeComments;}

	public function setWriteThumbnail( $writeThumbnail): void {$this->writeThumbnail = $writeThumbnail;}

	public function setWriteLink( $writeLink): void {$this->writeLink = $writeLink;}


    public function getUrl():string {return $this->url;}

	public function getPath():?string
    {
        if ($this->path) {
            return $this->path;
        }
        return null;
    }

    /**
     * Summary of getNameFile
     * @return string|null
     */
    public function getNameFile():?string
    {
        if ($this->fileName) {
           return $this->fileName;
        }
        
        return null;
    }

	public function getPlaylist():?string
    {
        if ($this->playlist) {
            return "--yes-playlist";
        }
        return null;
    }

	public function getWriteDescription():?string {
        if ($this->writeDescription) {
            return "--write-description";
        }
        return null;
    }

	public function getWriteComments():?string {
        if ($this->writeComments) {
            return "--write-comments";
        }
        return null;
    }

	public function getWriteThumbnail():?string 
    {
        if ($this->writeThumbnail) {
            return "--write-thumbnail";
        }
        return null;
    }

	public function getWriteLink():?string
    {
        if ($this->writeLink) {
            return "--write-link";
        }
        return null;
    }


    public function getMideaName($url): bool|string
    {
        $pathCutFile = $this->nameMidea = exec('yt-dlp --get-filename -o "%(title)s" '.$url);
        $pathCutFile = preg_replace('/[^a-z0-9._ \/]/', '', strtolower($pathCutFile));
        $pathCutFile = str_replace(' ', '-',  $pathCutFile);

        return  $pathCutFile;
    }

    public function setAudioFormat($audioFormat)
    {
        $this->audioFormat = $audioFormat;
    }

    public function getAudioFormat()
    {
        return $this->audioFormat;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }
 }
