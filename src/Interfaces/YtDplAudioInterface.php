<?php
namespace YtDpl\Interfaces;

interface YtDplAudioInterface
{
    public function generateFile();
    public function download($fileName);
    public function setAudioFormat($audioFormat);
    public function getAudioFormat();
    public function getOptionsExtensionFile(): void;
    public function buildCommandDownloadMedia(): string;
    public function getDurationMedia(): bool|string;
    public function cutFile($minValueDisplay, $maxValueDisplay, $fileName);
    public function getInfoMedia(): void;
}