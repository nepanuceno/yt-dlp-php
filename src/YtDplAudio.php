<?php
namespace YtDpl;

use YtDpl\Interfaces\YtDplAudioInterface;

class YtDplAudio extends YtDpl implements YtDplAudioInterface
{
    public $audioFormat;
    const NAME_FILE_TEMP = 'TESTE'; 

    public function __construct(){}

    public function setAudioFormat($audioFormat)
    {
        $this->audioFormat = $audioFormat;
    }

    public function getAudioFormat()
    {
        return $this->audioFormat;
    }

    public function generateFile(): bool|string
    {
        $comando = $this->buildCommand();
        try {
            exec($comando);
            return json_encode([
                'status'=>true,
                'messagem' => 'Ádio Extraído'
            ]);
        } catch (\Throwable $th) {
            return json_encode([
                'status'=>false,
                'messagem' => $th->getMessage()
            ]);
        }
    }

    public function cutFile($minValueDisplay, $maxValueDisplay, $fileName): bool|string{
        try {
            $path = $this->getPath().'/'.self::NAME_FILE_TEMP.'.'.$this->getAudioFormat();
            $pathCutFile = $this->getPath().'/'.$fileName.'.'.$this->getAudioFormat();

            exec('ffmpeg -i ' . escapeshellarg($path) . ' -ss '.$minValueDisplay.' -t '.$maxValueDisplay.' -c copy '. $pathCutFile);
            return json_encode([
                'status'=> true,
                'message' => 'ffmpeg -i ' . escapeshellarg($path) . ' -ss '.$minValueDisplay.' -t '.$maxValueDisplay.' -c copy '. $pathCutFile
            ]);
        } catch (\Throwable $th) {
            return json_encode([
                'status'=>false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function extractFile(): bool|string {
        return $this->generateFile();
    }

    public function extractInfoFile(): bool|string {
        $path = $this->getPath().'/'.self::NAME_FILE_TEMP.'.'.$this->getAudioFormat();

        return exec('ffprobe -i '.escapeshellarg($path).' -show_entries format=duration -v quiet -of csv="p=0"');
    }
	
    public function download($fileName)
    {
        set_time_limit(0);
        $file = $this->getPath().'/'.$fileName.'.'.$this->getAudioFormat();
        
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);

            unlink($this->getPath().'/'.self::NAME_FILE_TEMP.'.'.$this->getAudioFormat());
            unlink($file);
            exit;
        }
    }

    public function buildCommand()
    {
        return "yt-dlp ".$this->getPlaylist()." -x --audio-format " . $this->getAudioFormat() . " --no-restrict-filenames -o \"TESTE.".$this->getAudioFormat()."\" -P " . $this->getPath() . " " . $this->getUrl();
    }   
}
