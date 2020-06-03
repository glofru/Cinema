<?php


class CGestoreREST
{
    public static function proiezioniSettimanali() {
        $settimana = EHelper::getInstance()->getSettimana();
        $elenco = FPersistentManager::getInstance()->loadBetween($settimana[0], $settimana[1], "EProiezione");
        VGestoreREST::showJSON($elenco);
    }

    public static function proiezioniSettimanaProssima() {
        $settimana = EHelper::getInstance()->getSettimanaProssima();
        $elenco = FPersistentManager::getInstance()->loadBetween($settimana[0], $settimana[1], "EProiezione");
        VGestoreREST::showJSON($elenco);
    }

    public static function proiezioniSettimanaScorsa() {
        $settimana = EHelper::getInstance()->getSettimanaScorsa(1);
        $elenco = FPersistentManager::getInstance()->loadBetween($settimana[0], $settimana[1], "EProiezione");
        VGestoreREST::showJSON($elenco);
    }

    public static function filmProssimi() {
        $data = EHelper::getInstance()->getDateProssime();
        $film = FPersistentManager::getInstance()->loadBetween($data[0], $data[1], "EFilm");
        VGestoreREST::showJSONArray($film);
    }

    public static function myToken() {
        $whois = json_decode('php://input',true); //Torna un tipo associativo
        $utente = FPersistentManager::getInstance()->load($whois["email"], "email", "EUtente");
        if(isset($utente)) {
            VGestoreREST::showJSON(uniqid());
        } else {
            VGestoreREST::showJSON("ERRORE NELLA RICHIESTA");
        }
    }
}