<?php 
namespace YtDpl\Interfaces;

interface FfmpegInterface
{
    public function mideaSegment(string $startTime, string $endTime): array|null;
    public function trimmingFromBeginning(string $startTime): array|null;
    public function trimmingFromEnd(string $endTime): array|null;
}