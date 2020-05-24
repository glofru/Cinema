<?php


class EHelper
{
    private static EInputChecker $instance;

    private function __construct() {}

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new EInputChecker();
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
        $inizio = new DateTime('tomorrow');
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

    public function getDatePassate():array {
        $oggi = new DateTime('first day of this month - 2 weeks');
        $oggi->format('Y-m-d');
        $fine = new DateTime('first day of this month - 6 months');
        $fine = $fine->format('Y-m-d');
        $date = [];
        array_push($date,$oggi,$fine);
        return $date;
    }

}