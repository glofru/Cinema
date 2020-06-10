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

    public function isNome(string $nome): bool {
        //TODO
        return true;
    }

    public function isUsername(string $username): bool {
        $res = preg_replace("/[^a-zA-Z0-9]/", "", $username);
        return $res == $username && strlen($username) > 2;
    }

    public function isImage($typefile): bool
    {
        $estensione = strtolower(strrchr($typefile, '/'));

        switch($estensione)
        {
            case '/jpg':
            case '/jpeg':
            case '/gif':
            case '/png':
                return true;
            default:
                return false;
        }
    }

    public function isPassword(string $password): bool {
        return strlen($password) > 6;
    }

    public function isEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
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
        if (strlen($commento) === 0) {
            return "Nessun commento.";
        }

        $commento = filter_var($commento, FILTER_SANITIZE_STRING);
        if(strlen($commento) > 200) {
            $commento = substr($commento,0,200);
        }

        return $commento;
    }

    public function title(string $titolo): string {
        if (strlen($titolo) === 0) {
            return "Nessun titolo.";
        }

        $titolo = filter_var($titolo, FILTER_SANITIZE_STRING);
        if(strlen($titolo) > 30) {
            $titolo = substr($titolo,0,30);
        }

        return $titolo;
    }
}
?>