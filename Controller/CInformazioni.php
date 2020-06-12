<?php

class CInformazioni
{
    public static function getCosti() {
        if($_SERVER["REQUEST_METHOD"] === "GET") {
            VInformazioni::getCosti(CUtente::getUtente());
        } else {
            CMain::methodNotAllowed();
        }
    }

    public static function getAbout() {
        if($_SERVER["REQUEST_METHOD"] === "GET") {
            VInformazioni::getAbout(CUtente::getUtente());
        } else {
            CMain::methodNotAllowed();
        }
    }

    public static function getHelp() {
        if($_SERVER["REQUEST_METHOD"] === "GET") {
            VInformazioni::getHelp(CUtente::getUtente());
        } else {
            CMain::methodNotAllowed();
        }
    }
}