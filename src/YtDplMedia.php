<?php

namespace YtDpl;

use Brick\DateTime\Duration;
use YtDpl\Interfaces\YtDplAudioInterface;

class YtDplMedia extends YtDpl implements YtDplAudioInterface
{
    public $audioFormat;

    public function __construct() {}

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
                'status' => true,
                'messagem' => 'Mídea Extraída'
            ]);
        } catch (\Throwable $th) {
            return json_encode([
                'status' => false,
                'messagem' => $th->getMessage()
            ]);
        }
    }

    public function cutFile($minValueDisplay, $maxValueDisplay, $fileName): bool|string
    {
        try {
            $path = escapeshellarg($this->getPath() . '/' . $this->getFileTempName() . '.' . $this->getAudioFormat());
            $pathCutFile = escapeshellarg($this->getPath() . '/' . $this->getFileNameFormated() . '.' . $this->getAudioFormat());

            $minValueDisplay = Time::toHours($minValueDisplay);
            $maxValueDisplay = Time::toHours($maxValueDisplay);

            $comando = (new Ffmpeg(pathFileInput: $path, fileNameOutput: $pathCutFile))->mideaSegment(startTime: $minValueDisplay, endTime: $maxValueDisplay);

            return json_encode([
                'status' => true,
                'message' => $comando
            ]);
        } catch (\Throwable $th) {
            return json_encode([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getOptionsExtensionFile(): void
    {
        passthru('yt-dlp -F ' . $this->getUrl());
    }

    public function getDurationMedia(): string
    {
        $duration = exec('yt-dlp --get-duration ' . $this->getUrl(), $duration);
        $arrDuration = explode(':', $duration);

        switch (count(($arrDuration))) {
            case 1:
                return (int)$arrDuration[0];
            case 2:
                return (int)($arrDuration[0] * 60) + ((int)$arrDuration[1]);
            case 3:
                return (int)($arrDuration[0] * 3600) + (int)($arrDuration[1] * 60) + (int)$arrDuration[2];
            default:
                return 0;
        }
    }

    public function getInfoMedia(): void
    {
        exec('yt-dlp -F ' . $this->getUrl(), $output);
        print_r($output);
        $arrFormats = $this->extractFormats($output);
        print_r($arrFormats);
        // echo json_encode($output);
    }

    public function buildCommandDownloadMedia(): string
    {
        return sprintf(
            'yt-dlp --cache-dir /tmp/yt-dlp-cache -f %s -o %s/%s.%s %s',
            $this->getIdOptionMedia(),
            $this->getPath(),
            $this->getFileTempName(),
            $this->getAudioFormat(),
            $this->getUrl(),
        );
    }

    public function download($fileName)
    {
        set_time_limit(0);
        $file = $this->getPath() . '/' . $fileName . '.' . $this->getAudioFormat();

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);

            $arquivotemporario = $this->getPath() . '/' . $this->getFileTempName() . '.' . $this->getAudioFormat();
            unlink($arquivotemporario);
            unlink($file);
            exit;
        }
    }

    public function extractFormats(array $lines): array
    {
        $formats = [];

        foreach ($lines as $line) {
            // if (preg_match('/^(\w+)\s+(\w+)\s+([\w\s]+)\s+\|\s+([\w\s~]+)\s+\|\s+([\w\s]+)\s+([\w\s]+)\s+([\w\s]+)/', $line, $matches)) {
            //https://www.site24x7.com/pt/tools/regex-parser.html
            //Verificar linhas com | ~ 
            if (preg_match('/^(\w+)\s+(\w+)\s+([\w\s]+)\s+.\s+\|\s+([\d]+.[\d]+[a-zA-Z]+|\s*)/', $line, $matches)) {
                $formats[] = [
                    'id' => $matches[1],
                    'ext' => $matches[2],
                    'resolution' => $matches[3],
                    'filesize' => $matches[4] ?? null,
                ];
            }
        }

        return $formats;
    }
}
