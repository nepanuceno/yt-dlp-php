<?php 

use PHPUnit\Framework\TestCase;

class Ffmpeg extends TestCase
{
    public function testMediaSegment()
    {
        $ffmpeg = new YtDpl\Ffmpeg(
            pathFileInput: 'tests/test.mp4',
            fileNameOutput: 'tests/testSegment.mp4'
        );

        $ffmpeg->mideaSegment(startTime: '00:00:10', endTime: '00:00:20');
        $this->assertFileExists('tests/testSegment.mp4');
        unlink('tests/testSegment.mp4');
    }

    public function testTrimmingFromBeginning()
    {
        $ffmpeg = new YtDpl\Ffmpeg(
            pathFileInput: 'tests/test.mp4',
            fileNameOutput: 'tests/testTrimmingFromBeginning.mp4'
        );
        $ffmpeg->trimmingFromBeginning(startTime: '00:00:20');
        $this->assertFileExists('tests/testTrimmingFromBeginning.mp4');
        unlink('tests/testTrimmingFromBeginning.mp4');
    }

    public function testTrimmingFromEnd()
    {
        $ffmpeg = new YtDpl\Ffmpeg(
            pathFileInput: 'tests/test.mp4',
            fileNameOutput: 'tests/testTrimmingFromEnd.mp4'
        );
        $ffmpeg->trimmingFromEnd(endTime: '00:00:09');
        $this->assertFileExists('tests/testTrimmingFromEnd.mp4');
        unlink('tests/testTrimmingFromEnd.mp4');
    }
}