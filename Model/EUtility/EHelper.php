<?php


class EHelper
{
    private static $instance;

    private function __construct() {}

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new EHelper();
        }
        return self::$instance;
    }

    public function getDateProssime(): array {
        $result = [];
        $oggi = new DateTime('now');
        $oggi = $oggi->format('Y-m-d');
        $fine = "2100-01-01";
        array_push($result, $oggi, $fine);
        return $result;
    }

    public function getSettimana(): array {
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

    public function getSettimanaProssima(): array {
        $result = [];
        $inizio = new DateTime('now');
        $giorno = $inizio->format('D');
        $i = 0;
        $found = false;
        while(!$found) {
            $inizio->modify('+1 Day');
            $giorno = $inizio->format('D');
            if($giorno == 'Mon' && $i > 0) {$found = true;}
            $i++;
        }
        $inizio = $inizio->format('Y-m-d');
        $fine = DateTime::createfromFormat('Y-m-d', $inizio);
        $fine->modify('+ 6 Days');
        $fine = $fine->format('Y-m-d');
        array_push($result, $inizio, $fine);
        return $result;
    }

    public function getSettimanaScorsa(): array {
        $result = [];
        $inizio = new DateTime('now');
        $giorno = $inizio->format('D');
        $i = 0;
        $found = false;
        while(!$found) {
            $inizio->modify('-1 Day');
            $giorno = $inizio->format('D');
            if($giorno == 'Mon' && $i > 6) {$found = true;}
            $i++;
        }
        $inizio = $inizio->format('Y-m-d');
        $fine = DateTime::createfromFormat('Y-m-d',$inizio);
        $fine->modify('+ 6 Days');
        $fine = $fine->format('Y-m-d');
        array_push($result, $inizio, $fine);
        return $result;
    }

    public function getDatePassate():array {
        $oggi = new DateTime('first day of this month - 2 weeks');
        $oggi = $oggi->format('Y-m-d');
        $fine = new DateTime('first day of this month - 30 years');
        $fine = $fine->format('Y-m-d');
        $date = [];
        array_push($date, $oggi, $fine);
        return $date;
    }

    public function preferences ($cookie) {
        if(!isset($cookie)) {
            $value = [];
            $generi = EGenere::getAll();
            foreach ($generi as $key) {
                $value[$key] = 0;
            }
            $value = serialize($value);
            setcookie('preferences', $value, time() + (86400 * 30), "/");
        }
        $value = unserialize($cookie);
        return $value;
    }

    public function getPreferences($arr) {
        $isEmpty = true;
        $temp_values = [];
        $all = 0;
        foreach($arr as $key => $a) {
            if($a !== 0) {
                $isEmpty = false;
                $all++;
                $temp_values[$key] = $a;
            }
        }
        if($isEmpty === true) {return true;}
        foreach($temp_values as $key => $arr) {
            $temp_values[$key] = round(round(($arr / $all) * 100) * (11/100));
        }
        return $temp_values;
    }

    public function setPreferences(string $genere, $cookie) {
        $cookie[$genere]++;
        $cookie = serialize($cookie);
        setcookie('preferences', $cookie, time() + (86400 * 30), "/");
    }

    public function getMedia($g) {
        $p = 0;
        $n = sizeof($g);
        if($n === 0){
            return 0;
        }
        foreach($g as $elem){
            $p+=$elem->getPunteggio();
        }
        return ($p/$n);
    }

    public function checkWrite(/*ERegistrato */ $utente,$array): bool {
        /*if(isset($utente)){
            foreach($array as $a){
                if($a->getUtente()->getId() == $utente->getId()){
                    return false;
                }
            }
            return true;
        }

        return false;*/ return true;
    }

    public function retriveVote(string $punteggio): float {
        $punteggio = explode('.', $punteggio);
        $found = false;
        $str = $punteggio[0];
        for($i=0;$i<strlen($str);$i++){
            if(preg_match('/^[0-9]+$/', $str[$i])) {
                $punteggio[0] = $str[$i];
                break;
            }
        }
        return floatval($punteggio[0] . "." . $punteggio[1][0]);
    }

    public function retriveAnno(string $anno): float {
        $str = "";
        for($i=0;$i<strlen($anno);$i++){
            if(preg_match('/^[0-9]+$/', $anno[$i])) {
                $str = $anno[$i] . $anno[$i+1] . $anno[$i+2] . $anno[$i+3];
                break;
            }
        }
        return $str;
    }

    public function programmazione($proiezionifilm, EFilm $film): array {
        $result = [];
        $today = new DateTime('now');
        if(sizeof($proiezionifilm) === 0) {
            return $result;
        }
        foreach($proiezionifilm->getProiezioni() as $pro) {
            if($pro->getDataproieizone() > $today) {
                array_push($result, $pro);
            }
            else if($pro->getDataproieizone() == $today){
                if(strtotime($today->format('H:i')) - strtotime($pro->getDataProiezione()->format('H:i')) > 0) {
                    array_push($result, $pro);
                }
            }
        }
        return $result;
    }

    public function filter(array $film, float $votoInizio, float $votoFine, DateTime $annoInizio, DateTime $annoFine) {
        $result = [];
        foreach ($film as $f) {
            if($f->getDataRilascio() <= $annoFine && $f->getDataRilascio() >= $annoInizio && $f->getVotoCritica() >= $votoInizio && $f->getVotoCritica() <= $votoFine) {
                array_push($result, $f);
            }
        }
        return $result;
    }
}