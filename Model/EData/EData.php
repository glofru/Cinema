<?php


class EData extends DateTime
{
    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
    }

    public static function getDateProssime(): array {
        $result = [];

        $oggi = new DateTime('now');
        $oggi = $oggi->format('Y-m-d');
        $fine = "2100-01-01";

        array_push($result, $oggi, $fine);

        return $result;
    }

    public static function getSettimana(): array {
        $result = [];

        $inizio = new DateTime('now');
        $giorno = $inizio->format('D');

        while($giorno != 'Mon') {
            $inizio->modify('-1 Day');
            $giorno = $inizio->format('D');
        }

        $inizio = $inizio->format('Y-m-d');
        $fine = DateTime::createfromFormat('Y-m-d', $inizio);
        $fine->modify('+ 6 Days');
        $fine = $fine->format('Y-m-d');

        array_push($result, $inizio, $fine);

        return $result;
    }

    public static function getSettimanaProssima(): array {
        $result = [];

        $inizio = new DateTime('now');

        for($i = 0; true; $i++) {
            $inizio->modify('+1 Day');
            $giorno = $inizio->format('D');
            if($giorno == 'Mon' && $i > 0) {
                break;
            }
        }

        $inizio = $inizio->format('Y-m-d');
        $fine = DateTime::createfromFormat('Y-m-d', $inizio);
        $fine->modify('+ 6 Days');
        $fine = $fine->format('Y-m-d');

        array_push($result, $inizio, $fine);

        return $result;
    }

    public static function getSettimanaScorsa(int $n): array {
        $result = [];

        $inizio = new DateTime('now');

        $k = ($n * 6);
        if($n > 2) {$k += $n - 2;}

        for($i = 0; true; $i++) {
            $inizio->modify('-1 Day');
            $giorno = $inizio->format('D');
            if($giorno == 'Mon' && $i >= $k) {
                break;
            }
        }

        $inizio = $inizio->format('Y-m-d');
        $fine = DateTime::createfromFormat('Y-m-d',$inizio);
        $fine->modify('+ 6 Days');
        $fine = $fine->format('Y-m-d');

        array_push($result, $inizio, $fine);

        return $result;
    }

    public static function getDatePassate():array {
        $oggi = new DateTime('first day of this month - 2 weeks');
        $oggi = $oggi->format('Y-m-d');

        $fine = new DateTime('first day of this month - 30 years');
        $fine = $fine->format('Y-m-d');

        $date = [];

        array_push($date, $oggi, $fine);

        return $date;
    }

    public static function hoursandmins($time, $format = '%02d:%02d') {
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }
}