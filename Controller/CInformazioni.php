<?php
require_once "configCinema.conf.php";

class CInformazioni
{
    public static function getCosti() {
        $utente = CUtente::getUtente();
        if(isset($utente)){
            $isAdmin = $utente->isAdmin();
        } else {
            $isAdmin = false;
        }
        VInformazioni::getCosti($utente, $isAdmin);
    }
}