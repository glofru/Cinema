<?php

class CInformazioni
{
    public static function getCosti() {
        if($_SERVER["REQUEST_METHOD"] === "GET") {
            $data = self::controls();
            VInformazioni::getCosti($data[0], $data[1]);
        } else {
            CMain::methodNotAllowed();
        }
    }

    public static function getAbout() {
        if($_SERVER["REQUEST_METHOD"] === "GET") {
            $data = self::controls();
            VInformazioni::getAbout($data[0], $data[1]);
        } else {
            CMain::methodNotAllowed();
        }
    }

    private static function controls(): array {
        $isAdmin = CUtente::isLogged() && CUtente::getUtente()->isAdmin();
        $result = [];
        array_push($result, CUtente::getUtente(), $isAdmin);
        return $result;

    }

    public static function getHelp() {
        if($_SERVER["REQUEST_METHOD"] === "GET") {
            $data = self::controls();
            VInformazioni::getHelp($data[0], $data[1]);
        } else {
            CMain::methodNotAllowed();
        }
    }
}