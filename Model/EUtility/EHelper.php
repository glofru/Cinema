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
                $all += $a;
                $temp_values[$key] = $a;
            }
        }
        if($isEmpty === true) {return true;}
        foreach($temp_values as $key => $arr) {
            $temp_values[$key] = round(round(($arr / $all) * 100) * (10/100));
        }
        return $temp_values;
    }

    public function setPreferences(string $genere, $cookie) {
        $cookie[$genere]++;
        $cookie = serialize($cookie);
        setcookie('preferences', $cookie, time() + (86400 * 30), "/");
    }

    //TODO: Foundation
    public function programmazione(EProgrammazioneFilm $proiezionifilm): EProgrammazioneFilm {
        $result = new EProgrammazioneFilm();
        $today = new DateTime('now');

        foreach($proiezionifilm->getProiezioni() as $pro) {
            if($pro->getDataproieizone() > $today) {
                $result->addProiezione($pro);
            } else if($pro->getDataproieizone() == $today){
                if(strtotime($today->format('H:i')) - strtotime($pro->getDataProiezione()->format('H:i')) > 0) {
                    $result->addProiezione($pro);
                }
            }
        }

        return $result;
    }

    //TODO: Foundation
    public function filter(array $film, float $votoInizio, float $votoFine, DateTime $annoInizio, DateTime $annoFine) {
        $result = [];
        foreach ($film as $f) {
            if($f->getDataRilascio() <= $annoFine && $f->getDataRilascio() >= $annoInizio && (($f->getVotoCritica() >= $votoInizio && $f->getVotoCritica() <= $votoFine) || $f->getVotoCritica() == 0)) {
                array_push($result, $f);
            }
        }
        return $result;
    }

    //TODO: FUtility
    public function hash(string $password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}