<?php
namespace YtDpl;

class YtDlpVideo extends YtDpl
{
    public function getInfoMedia(): bool|string
    {        
        $a = system('yt-dlp -F '. $this->getUrl());
        return $a;
    }

    public function parseFormatOutput(string $output): string {
        // Divide a string de entrada em linhas
        $lines = explode("\n", $output);
        $formats = [];
        $headerFound = false;
        $columns = [];
        
        // Itera sobre cada linha
        foreach ($lines as $line) {
            // Identifica a linha de cabeçalho
            if (strpos($line, "ID      EXT   RESOLUTION") !== false) {
                $headerFound = true;
                continue;
            }

            // Ignora linhas antes do cabeçalho ou linhas de separação
            if (!$headerFound || strpos($line, "----") !== false || empty(trim($line))) {
                continue;
            }

            // Processa linha de dados
            $parts = explode("|", $line);
            if (count($parts) >= 3) {
                $format = [];
                
                // Processa primeira parte (ID, EXT, RESOLUTION, FPS, CH)
                $firstPart = array_values(array_filter(explode(" ", trim($parts[0]))));
                $format['id'] = $firstPart[0] ?? '';
                $format['ext'] = $firstPart[1] ?? '';
                $format['resolution'] = $firstPart[2] ?? '';
                $format['fps'] = $firstPart[3] ?? '';
                if (isset($firstPart[4])) {
                    $format['channels'] = $firstPart[4];
                }

                // Processa segunda parte (FILESIZE, TBR, PROTO)
                $secondPart = array_values(array_filter(explode(" ", trim($parts[1]))));
                if (!empty($secondPart[0])) {
                    $format['filesize'] = $secondPart[0];
                }
                if (!empty($secondPart[1])) {
                    $format['tbr'] = $secondPart[1];
                }
                if (!empty($secondPart[2])) {
                    $format['protocol'] = $secondPart[2];
                }

                // Processa terceira parte (VCODEC, VBR, ACODEC, ABR, ASR, MORE INFO)
                $thirdPart = array_values(array_filter(explode(" ", trim($parts[2]))));
                $moreInfo = [];
                $currentIndex = 0;

                // Processa VCODEC
                if ($thirdPart[0] == 'audio') {
                    $format['vcodec'] = 'audio only';
                    $currentIndex = 2; // Pula "audio only"
                } else {
                    $format['vcodec'] = $thirdPart[0];
                    $currentIndex = 1;
                }

                // Processa restante das informações
                for ($i = $currentIndex; $i < count($thirdPart); $i++) {
                    $value = $thirdPart[$i];
                    
                    // Processa codec de áudio
                    if (strpos($value, 'mp4a') !== false || strpos($value, 'opus') !== false) {
                        $format['acodec'] = $value;
                    }
                    // Processa bitrate se terminar com 'k'
                    else if (substr($value, -1) === 'k' && is_numeric(substr($value, 0, -1))) {
                        if (!isset($format['vbr'])) {
                            $format['vbr'] = $value;
                        } else if (!isset($format['abr'])) {
                            $format['abr'] = $value;
                        }
                    }
                    // Coleta informações adicionais
                    else if ($value === '[pt]' || !empty($moreInfo)) {
                        $moreInfo[] = $value;
                    }
                }

                // Adiciona informações extras se existirem
                if (!empty($moreInfo)) {
                    $format['more_info'] = implode(' ', $moreInfo);
                }

                // Adiciona o formato ao array de formatos se não estiver vazio
                if (!empty($format)) {
                    $formats[] = $format;
                }
            }
        }

        // Retorna o JSON formatado
        return json_encode([
            'formats' => $formats
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}