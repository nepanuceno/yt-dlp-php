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
     * @return void
     */
    public function mideaSegment(string $startTime, string $endTime): void
    {
        $command = "ffmpeg -i {$this->pathFileInput} -ss {$startTime} -to {$endTime} -c:v copy -c:a copy {$this->fileNameOutput}";
        $this->run(command: $command);
    }

    /**
     * Summary of trimmingFromBeginning
     * Trimming from the beginning
     * @param string $startTime 
     * @return void
     */
    public function trimmingFromBeginning(string $startTime): void
    {
        $command = "ffmpeg -ss {$startTime} -i {$this->pathFileInput} -c:v copy -c:a copy {$this->fileNameOutput}";
        $this->run(command: $command);
    }


    /**
     * Summary of trimmingFromEnd
     * Trim from a specific point to the end:
     * @param string $endTime 
     * @return void
     * 
     */
    public function trimmingFromEnd(string $endTime): void
    {
        $command = "ffmpeg -ss {$endTime} -i {$this->pathFileInput} {$this->fileNameOutput}";
        $this->run(command: $command);
    }

    /**
     * Summary of run
     * @param string $command
     * @return void
     */
    private function run(string $command): void
    {
        exec(command: $command, output: $output, result_code: $return);
    }
}