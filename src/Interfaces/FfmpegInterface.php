<?php 
namespace YtDpl\Interfaces;
interface FfmpegInterface
{
    public function mideaSegment(string $startTime, string $endTime): void;
    public function trimmingFromBeginning(string $startTime): void;
    public function trimmingFromEnd(string $endTime): void;
}