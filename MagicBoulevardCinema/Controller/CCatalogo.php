<?php

/**
 * Nella classe Catalogo abbiamo dei metodi necessari a permette di ottenere i film di prossima uscita, i film presenti nelle programmazioni delle settimane precedenti e i film più apprezzati dagli utenti.
 * Class CCatalogo
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Controller
 */
class CCatalogo
{
    /**
     * Funzione che permette di ottenere al massimo i 20 film che sono prossimi ad essere rilasciati. Accessibile solo via GET.
     */
    public static function prossimeUscite() {
        if($_SERVER["REQUEST_METHOD"] === "GET") {
            $utente = CUtente::getUtente();
            $result = CUtility::getProssimi(20);
            $consigliati = CUtility::getConsigliati($utente);
            VCatalogo::prossimeUscite($result, $utente, $consigliati);
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione che permette di ottenere le programmazioni delle settimane nell'intervallo compreso fra 2 settimane e 6 settimane fa. Accessibile solo via GET.
     */
    public static function programmazioniPassate() {
        if($_SERVER["REQUEST_METHOD"] === "GET") {
            $utente = CUtente::getUtente();
            $consigliati = CUtility::getConsigliati($utente);
            $film = [];
            $immagini = [];
            $punteggio = [];
            $date = [];
            $toShow = [];
            for ($i = 2; $i < 6; $i++) {
                $temp = EData::getSettimanaScorsa($i);
                $values = [];
                array_push($values, DateTime::createFromFormat('Y-m-d', $temp[0]), DateTime::createFromFormat('Y-m-d', $temp[1]));
                array_push($toShow, "Settimana dal " . $values[0]->format('d-m-y') . " al " . $values[1]->format('d-m-y'));
                $temp = CUtility::getProiezioni($temp);
                array_push($film, $temp[0]);
                array_push($immagini, $temp[1]);
                array_push($punteggio, $temp[2]);
                array_push($date, $temp[3]);
            }
            VCatalogo::programmazioniPassate($film, $immagini, $punteggio, $date, $utente, $consigliati, $toShow);
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione che permettere di ottenere la top 10 dei film con la media voti, dei giudizi espressi dagli utenti, più alta. Accessibile solo via GET.
     */
    public static function piuApprezzati() {
        if($_SERVER["REQUEST_METHOD"]) {
            $utente = CUtente::getUtente();

            $consigliati = CUtility::getConsigliati($utente);
            $oggi = EData::getDateProssime();
            $film = FPersistentManager::getInstance()->loadBetween('0000-00-00', $oggi[0], "EFilm");

            $punteggi = [];

            foreach ($film as $item) {
                $giudizi = FPersistentManager::getInstance()->load($item->getId(), "idFilm", "EGiudizio");

                if (sizeof($giudizi) === 0) {
                    $p = 0;
                } else {
                    $p = EGiudizio::getMedia($giudizi);
                }

                $punteggi[$item->getId()] = $p;
            }

            $res = arsort($punteggi);
            if (sizeof($punteggi) > 10) {
                array_splice($punteggi, 0, 10);
            }

            $filmApprezzati = [];
            $immaginiApprezzati = [];

            foreach ($punteggi as $key => $p) {
                foreach ($film as $f) {
                    if ($f->getId() == $key) {
                        array_push($filmApprezzati, $f);
                        array_push($immaginiApprezzati, FPersistentManager::getInstance()->load($key, "idFilm", "EMedia"));
                        break;
                    }
                }

            }

            $result = [];
            array_push($result, $filmApprezzati, $immaginiApprezzati, $punteggi);

            VCatalogo::piuApprezzati($result, $utente, $consigliati);
        }
    }
}