<?php 

namespace YtDpl;

use Brick\DateTime\Duration;

class Time {

    public static function toHours(string $seconds) {
        $duration = Duration::ofSeconds($seconds);

        $horas = $duration->toHoursPart();
        $minutos = $duration->toMinutesPart();
        $segundos = $duration->toSecondsPart();

        return sprintf("%02d:%02d:%02d", $horas, $minutos, $segundos);
    }
}