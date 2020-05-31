<?php
require_once "configCinema.conf.php";

class CInformazioni
{
    public static function getCosti() {
        $data = self::controls();
        VInformazioni::getCosti($data[0], $data[1]);
    }

    public static function getAbout() {
        $data = self::controls();
        VInformazioni::getAbout($data[0], $data[1]);
    }

    private static function controls(): array {
        $utente = CUtente::getUtente();
        if(isset($utente)){
            $isAdmin = $utente->isAdmin();
        } else {
            $isAdmin = false;
        }
        $result = [];
        array_push($result, $utente, $isAdmin);
        return $result;
    }
}