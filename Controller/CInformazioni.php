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
        $isAdmin = CUtente::isLogged() && CUtente::getUtente()->isAdmin();
        $result = [];
        array_push($result, CUtente::getUtente(), $isAdmin);
        return $result;
    }
}