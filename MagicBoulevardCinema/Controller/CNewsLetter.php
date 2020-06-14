<?php

/**
 * La classe Newsletter mette a disposizione dei metodi necessari per gestire l'invio di informazioni agli utenti iscritti alla newsletter.
 * Class CNewsLetter
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Controller
 */
class CNewsLetter
{
    /**
     * Funzione che andrebbe chiamata sfruttando un'applicazione di Cron-Jobs ma che non possiamo usare in quanto il sito non è online ma solo in un server locale.
     * Un Cron-Job fissato per le 21:00 di ogni giovedì della settimana dovrebbe richiamare la seguente funzione per inviare a tutti gli utenti iscritti alla newsletter
     * la programmazione della prossima settimana.
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public static function sendNewsLetter() {
        if($_SERVER['REQUEST_METHOD']=="GET" && $_GET["token"] === "S3ndM34M41l") {
            $ns = FPersistentManager::getInstance()->loadAll("ENewsLetter");
            if(sizeof($ns->getListaUtenticonPreferenze()[0]) > 0) {
                $date    = EData::getSettimanaProssima();
                $results = CUtility::getProiezioni($date);

                foreach ($ns->getListaUtenticonPreferenze()[0] as $utente) {
                    CMail::newsLetter($utente, $date, $results);
                }
            }
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione, da richiamare quando viene caricato un nuovo film nel sistema, che permette di individuare gli utenti iscritti alla newsletter
     * quelli con genere preferito quello del film appena inserito.
     * Per ognuno viene inviata una mail con le informazioni sul nuovo film appena inserito.
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public static function addedNewFilm() {
        if (!CUtente::isLogged() || !CUtente::getUtente()->isAdmin()) {
            CMain::forbidden();
        } else {
            $film = FPersistentManager::getInstance()->load($_SESSION["idFilm"], "id", "EFilm")[0];
            unset($_SESSION["idFilm"]);

            if (isset($film)) {
                $ns = FPersistentManager::getInstance()->loadAll("ENewsLetter");
                $pref = $film->getGenere();

                foreach ($ns->getListaUtenticonPreferenze()[1] as $key => $genere) {
                    foreach ($genere as $g) {
                        if ($g === $pref) {
                            CMail::addedNewFilm($ns->getListaUtenticonPreferenze()[0][$key], $film);
                            break;
                        }
                    }
                }
            }
        }
    }
}