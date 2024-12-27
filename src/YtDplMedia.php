<?php
namespace YtDpl;

use YtDpl\Interfaces\YtDplAudioInterface;

class YtDplMedia extends YtDpl implements YtDplAudioInterface
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
        $comando = $this->buildCommandDownloadMedia();
        try {
            exec($comando);
            return json_encode([
                'status'=>true,
                'messagem' => 'Mídea Extraída'
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
            $pathCutFile = $this->getPath().'/'.$this->getFileNameFormated().'.'.$this->getAudioFormat();
                        
            $comando = sprintf(
                'ffmpeg -i %s -ss %s -t %s -c copy %s',
                escapeshellarg($path),
                $minValueDisplay,
                $maxValueDisplay,
                $pathCutFile
            );            
            
            $resp = exec($comando, $resp);                        
            
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

    public function getOptionsExtensionFile(): void
    {
        passthru('yt-dlp -F '. $this->getUrl());
    }

    public function getDurationMedia(): bool|string
    {
        $duration = exec('yt-dlp --get-duration '. $this->getUrl(), $duration);
        $arrDuration = explode(':',$duration);

        return (int)($arrDuration[0]*60) + (int)$arrDuration[1];
    }

    // public function getNameMidea(): bool|string
    // {        
    //     return exec('yt-dlp --get-title '. $this->getUrl(), $title);
    // }

    public function getInfoMedia(): void
    {        
        passthru('yt-dlp -F '. $this->getUrl());
    }
    
    public function buildCommandDownloadMedia(): string {
        return sprintf(
            'yt-dlp -f %s -P %s %s',
            $this->getIdOptionMedia(),
            $this->getPath(),
            $this->getUrl()
        );
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
}
