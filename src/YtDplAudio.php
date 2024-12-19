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

    public function generateFile(): bool|string
    {
        $comando = $this->buildCommand();
        try {
            exec($comando);
            return json_encode([
                'status'=>true,
                'messagem' => 'Áudio Extraído'
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
            $path = $this->getPath().'/'.$this->getFileName().'.'.$this->getAudioFormat();
            $pathCutFile = $this->getPath().'/'.$fileName.'.'.$this->getAudioFormat();
                        
            $comando = sprintf(
                'ffmpeg -i %s -ss %s -t %s -c copy %s',
                escapeshellarg($path),
                $minValueDisplay,
                $maxValueDisplay,
                $pathCutFile
            );
            exec($comando);            
            
            return json_encode([
                'status'=> true,
                'message' => $comando
            ]);
        } catch (\Throwable $th) {
            return json_encode([
                'status'=>false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function extractInfoFile(): bool|string {
        $path = $this->getPath().'/'.$this->getFileName().'.'.$this->getAudioFormat();

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

            unlink($this->getPath().'/'.$this->getFileName().'.'.$this->getAudioFormat());
            unlink($file);
            exit;
        }
    }

    public function buildCommand()
    {
        $nomeArquivo = $this->getFileName();
        $comando = sprintf(
            'yt-dlp %s -x --audio-format %s --no-restrict-filenames -o "%s.%s" -P %s %s',
            $this->getPlaylist(),
            $this->getAudioFormat(),
            $nomeArquivo,
            $this->getAudioFormat(),
            $this->getPath(),
            $this->getUrl()
        );
        return $comando;
    }   
}
