<?php

/**
 * La classe GestoreREST contiene i metodi necessari a poter rendere l'app RESTFULL ritornando come risultato oggetti che verranno poi espressi in formato JSON.
 * Class CGestoreREST
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Controller
 */
class CGestoreREST
{
    /**
     * Funzione che genera un ElencoProgrammazioni con le proieizoni presenti nella settimana corrente.
     */
    public static function proiezioniSettimanali() {
        $settimana = EData::getSettimana();
        $elenco = FPersistentManager::getInstance()->loadBetween($settimana[0], $settimana[1], "EProiezione");
        VGestoreREST::showJSON($elenco);
    }

    /**
     * Funzione che individua le proiezione della prossima settimana.
     */
    public static function proiezioniSettimanaProssima() {
        $settimana = EData::getSettimanaProssima();
        $elenco = FPersistentManager::getInstance()->loadBetween($settimana[0], $settimana[1], "EProiezione");
        VGestoreREST::showJSON($elenco);
    }

    /**
     * Funzione che carica le proiezioni che sono avvenute nella settimana scorsa.
     */
    public static function proiezioniSettimanaScorsa() {
        $settimana = EData::getSettimanaScorsa(1);
        $elenco = FPersistentManager::getInstance()->loadBetween($settimana[0], $settimana[1], "EProiezione");
        VGestoreREST::showJSON($elenco);
    }

    /**
     * Funzione che riporta l'insieme di film che non sono ancora usciti ma sono prossimi al rilascio.
     */
    public static function filmProssimi() {
        $data = EData::getDateProssime();
        $film = FPersistentManager::getInstance()->loadBetween($data[0], $data[1], "EFilm");
        VGestoreREST::showJSONArray($film);
    }

    /**
     * Funzione che simula la richiesta di un token per l'accesso alla piattaforma. Decodificata la email dell'utente dal formato JSON viene controllaata la reale esistenza nel DB di quest'ultima.
     * Se esiste si provede ad inviare un token univoco.
     */
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