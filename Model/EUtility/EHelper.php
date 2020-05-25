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

    public function username(string $username): bool {
        $res = preg_replace("/[^a-zA-Z]/", "", $username);
        if(strlen($username) < 8 || $res !== $username ) {
            return false;
        }
        return true;
    }

    public function password(string $password): bool {
        if(strlen($password) < 8) {
            return false;
        }
        return true;
    }

    public function email(string $email): bool {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public function date(string $date) {
        $elem = explode("-",$date);
        if(sizeof($elem) !== 3) {
            return false;
        }
        return checkdate($elem[1],$elem[2],$elem[0]);
    }

    public function hour(string $hour) {
        $res = strtotime($hour);
        if($res !== false){
            return true;
        }
        return $res;
    }

    public function getDateProssime(): array {
        $result = [];
        $oggi = new DateTime('now');
        $oggi = $oggi->format('Y-m-d');
        $fine = "2100-01-01";
        array_push($result,$oggi,$fine);
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
        $fine = DateTime::createfromFormat('Y-m-d',$inizio);
        $fine->modify('+ 6 Days');
        $fine = $fine->format('Y-m-d');
        array_push($result,$inizio,$fine);
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
        $fine = DateTime::createfromFormat('Y-m-d',$inizio);
        $fine->modify('+ 6 Days');
        $fine = $fine->format('Y-m-d');
        array_push($result,$inizio,$fine);
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
        array_push($result,$inizio,$fine);
        return $result;
    }

    public function getDatePassate():array {
        $oggi = new DateTime('first day of this month - 2 weeks');
        $oggi = $oggi->format('Y-m-d');
        $fine = new DateTime('first day of this month - 30 years');
        $fine = $fine->format('Y-m-d');
        $date = [];
        array_push($date,$oggi,$fine);
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
            setcookie('preferences',$value,time() + (86400 * 30),"/");
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
        setcookie('preferences',$cookie,time() + (86400 * 30), "/");
    }

    public function getMedia(array $g) {
        $p = 0;
        $n = sizeof($g);
        echo $n . "<br>";
        if($n === 0){
            return 0;
        }
        foreach($g as $elem){
            $p+=$elem->getPunteggio();
        }
        return ($p/$n);
    }
}