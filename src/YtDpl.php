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

    public function __construct(){}

    public function setUrl( $url): void {$this->url = $url;}

	public function setPath( $path): void {$this->path = $path;}

    public function setNameFile($nameFile):void {$this->nameFile = $nameFile;}

	public function setPlaylist( $playlist): void {$this->playlist = $playlist;}

	public function setWriteDescription( $writeDescription): void {$this->writeDescription = $writeDescription;}

	public function setWriteComments( $writeComments): void {$this->writeComments = $writeComments;}

	public function setWriteThumbnail( $writeThumbnail): void {$this->writeThumbnail = $writeThumbnail;}

	public function setWriteLink( $writeLink): void {$this->writeLink = $writeLink;}


    public function getUrl():string {return $this->url;}

	public function getPath():string
    {
        if ($this->path) {
            return "-P ".$this->path;
        }
        return null;
    }

    public function getNameFile():string
    {
        if ($this->nameFile) {
            return " --no-restrict-filenames -o \"TESTE.mp3\" ".$this->path;
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
        return null;}

 }
