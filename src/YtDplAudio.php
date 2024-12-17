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

    public function generateFile()
    {
        $comando = $this->buildCommand();
        try {
            exec($comando);
        } catch (\Throwable $th) {
            //throw $th;

            return json_encode([
                'status'=>false,
                'messagem' => $th->getMessage()
            ]);
        }
        // passthru($comando); 
        // print_r($resp);
        // die();
    }

    public function extractFile() {
        $this->generateFile();
    }

    public function extractInfoFile(): bool|string {
        $path = dirname(__DIR__) . '/file_temp/TESTE.mp3';
        return exec('ffprobe -i '.escapeshellarg($path).' -show_entries format=duration -v quiet -of csv="p=0"');
    }
	
    public function download()
    {
        
        // set_time_limit(0);
        // $file = '/var/www/file_temp/TESTE.mp3';
        
        // if (file_exists($file)) {
        //     header('Content-Description: File Transfer');
        //     header('Content-Type: application/octet-stream');
        //     header('Content-Disposition: attachment; filename="'.basename($file).'"');
        //     header('Expires: 0');
        //     header('Cache-Control: must-revalidate');
        //     header('Pragma: public');
        //     header('Content-Length: ' . filesize($file));
        //     readfile($file);
        //     exit;
        // }
    }

    public function buildCommand()
    {
        return "yt-dlp ".$this->getPlaylist()." -x --audio-format " . $this->getAudioFormat() . " --no-restrict-filenames -o \"TESTE.mp3\" " . $this->getPath() . " " . $this->getUrl();
    }   
}
