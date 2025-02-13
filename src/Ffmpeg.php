<?php 

namespace YtDpl;

use YtDpl\Interfaces\FfmpegInterface;

class Ffmpeg implements FfmpegInterface
{
    public function __construct(
        protected string $pathFileInput, 
        protected string $fileNameOutput
    ){}

    /**
     * Summary of videoSegment
     * Trim a segment of a video
     * @param string $startTime
     * @param string $endTime
     * @return array|null
     */
    public function mideaSegment(string $startTime, string $endTime): array|null   
    {
        $command = "ffmpeg -i {$this->pathFileInput} -ss {$startTime} -to {$endTime} -c:v copy -c:a copy {$this->fileNameOutput}";
        return $this->run(command: $command);
    }

    /**
     * Summary of trimmingFromBeginning
     * Clips the media from a specific time point to the end time of the file.
     * @param string $startTime 
     * @return void
     */
    public function trimmingFromBeginning(string $startTime): array|null
    {
        $command = "ffmpeg -ss {$startTime} -i {$this->pathFileInput} -c:v copy -c:a copy {$this->fileNameOutput}";
        return $this->run(command: $command);
    }


    /**
     * Summary of trimmingFromEnd
     * Trims the segment from the beginning of the video to the specified time point.
     * @param string $endTime 
     * @return void
     * 
     */
    public function trimmingFromEnd(string $endTime): array|null
    {
        $command = "ffmpeg -ss 00:00:00 -i {$this->pathFileInput} -to {$endTime} -c:v copy -c:a copy {$this->fileNameOutput}";
        return $this->run(command: $command);
    }

    /**
     * Summary of run
     * @param string $command
     * @return array|null
     */
    private function run(string $command): array|null
    {
        exec(command: $command, output: $output, result_code: $return);
        return $output;
    }
}