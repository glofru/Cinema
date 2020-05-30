<?php
class EInputChecker{
    private static $instance;

    private function __construct() {}

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new EInputChecker();
        }
        return self::$instance;
    }

    public function username(string $username): string {
       /* $res = preg_replace("/[^a-zA-Z]/", "", $username);
        if(strlen($username) < 8 || $res !== $username ) {
            return "";
        }*/
        return $username;
    }

    public function password(string $password): string {
        if(strlen($password) < 8) {
            return "";
        }
        //$password = 'S4L7' . $password;
        //return hash('SHA512', $password);
        return $password;
    }

    public function email(string $email): string {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "";
        }
        return $email;
    }

    public function date(string $date): string {
        $temp = DateTime::createfromFormat('Y-m-d', $date);
        if($date === false) {
            return "";
        }
        return $date;
    }

    public function hour(string $hour): string {
        $res = strtotime($hour);
        if($res !== false){
            return "";
        }
        return $res;
    }

    public function comment(string $commento): string {
        if(strlen($commento) === 0) {
            return "Nessun Commento";
        }
        $commento = filter_var($commento, FILTER_SANITIZE_STRING);
        if(strlen($commento) > 200) {
            $commento = substr($commento,0,200);
        }
        return $commento;
    }

    public function title(string $titolo): string {
        if(strlen($titolo) === 0) {
            return "Nessun Titolo";
        }
        $titolo = filter_var($titolo, FILTER_SANITIZE_STRING);
        if(strlen($titolo) > 30) {
            $titolo = substr($titolo,0,30);
        }
        return $titolo;
    }
}
?>