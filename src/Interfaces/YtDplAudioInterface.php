<?php
namespace YtDpl\Interfaces;

interface YtDplAudioInterface
{
    public function generateFile();
    public function download($fileName);
    public function setAudioFormat($audioFormat);
    public function getAudioFormat();
    public function buildCommand();
    public function extractInfoFile();
    public function cutFile($minValueDisplay, $maxValueDisplay, $fileName);
    public function getMideaName($url): bool|string;
}