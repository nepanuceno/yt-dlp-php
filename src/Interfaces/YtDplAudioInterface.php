<?php
namespace YtDpl\Interfaces;

interface YtDplAudioInterface
{
    public function download();
    public function setAudioFormat($audioFormat);
    public function getAudioFormat();
    public function buildCommand();
}