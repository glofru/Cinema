<?php

/**
 * La classe Admin contiene tutti i metodi necessari a mostrare le schermate di gestione di utenti, film, proiezioni, sale e prezzi.
 * Class VAdmin
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package View
 */
class VAdmin
{
    /**
     * Funzione che permette di visualizzare la schermata di gestione degli utenti. Da questa è possibile visualizzare gli utenti bannati ed eventualmente bannarne altri.
     * @param array $bannati, insieme degli utenti bannati.
     * @param EAdmin $utente, utente che richiede la pagina.
     * @param null $status, risultato dell'operazione eseguita.
     * @throws SmartyException
     */
    public static function gestioneUtenti(array $bannati, EAdmin $utente, $status = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("bannati", $bannati);
        $smarty->assign("utente", $utente);
        $smarty->assign("status", $status);

        $smarty->display("gestioneUtenti.tpl");
    }

    /**
     * Schermata che permette di visualizzare la schermata di modifica dei prezzi dei biglietti.
     * @throws SmartyException
     */
    public static function modificaPrezzo() {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("price", $GLOBALS["prezzi"]);
        $smarty->assign("extra", $GLOBALS["extra"]);

        $smarty->display("modificaPrezzi.tpl");
    }

    public static function gestioneFilm(EUtente $utente, array $attori, array $registi, $erroreFilm = null, $errorePersona = null, $data = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("utente", $utente);
        $smarty->assign("attori", $attori);
        $smarty->assign("registi", $registi);
        $smarty->assign("generi", EGenere::getAll());
        $smarty->assign("errorAddFilm", $erroreFilm);
        $smarty->assign("errorAddPersona", $errorePersona);

        if ($erroreFilm) {
            $smarty->assign("titolo", $_POST["titolo"]);
            $smarty->assign("descrizione", $_POST["descrizione"]);
            $smarty->assign("genere", $_POST["genere"]);
            $smarty->assign("durata", $_POST["durata"]);
            $smarty->assign("trailerURL", $_POST["trailerURL"]);
            $smarty->assign("votoCritica", $_POST["votoCritica"]);
            $smarty->assign("dataRilascio", $_POST["dataRilascio"]);
            $smarty->assign("paese", $_POST["paese"]);
            $smarty->assign("etaConsigliata", $_POST["etaConsigliata"]);
        } if ($errorePersona) {
            //TODO
        }

        $smarty->display("gestioneFilm.tpl");
    }

    /**
     * Schermata che permette di visualizzare e gestire la disponibilità delle sale presenti nel cinema. Inoltre permette di aggiungere nuove sale.
     * @param array $sale, insieme delle sale fisiche presenti nel cinema.
     * @param EUtente $utente, utente che richiede la pagina,
     * @param null $e, esito dell'operazione eseguita.
     * @param null $nSala, numero di sala. Viene restituito nel caso l'operazione di aggiunta di una sala non sia andata a buon fine.
     * @param null $nFile, numero delle fine presenti nella sala. Viene restituito nel caso l'operazione di aggiunta di una sala non sia andata a buon fine.
     * @param null $nPosti, numero dei posti presenti in ogni fila. Viene restituito nel caso l'operazione di aggiunta di una sala non sia andata a buon fine.
     * @throws SmartyException
     */
    public static function gestioneSale(array $sale, EUtente $utente, $e = null, $nSala = null, $nFile = null, $nPosti = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("sale", $sale);
        $smarty->assign("utente", $utente);
        $smarty->assign("status", $e);
        $smarty->assign("nSala", $nSala);
        $smarty->assign("nFile", $nFile);
        $smarty->assign("nPosti", $nPosti);

        $smarty->display("gestioneSale.tpl");
    }

    /**
     * Funzione che permette di vsiualizzare le programmazioni delle proiezioni che avverranno nel cinema. Da qui è possibile aggiungere delle proiezioni oppure modificarle.
     * @param EUtente $utente, utente che richiede la pagina.
     * @param array $films, insieme dei film in proiezione.
     * @param array $sale, insieme delle sale fisiche.
     * @param EElencoProgrammazioni $programmazioni, elenco con le programmazioni dei vari film.
     * @param array $locandine, insieme delle locandine dei film.
     * @param int|null $film, id del film del quale si voleva creare una proeizione. Viene restituito nel caso l'operazione di aggiunta di una proiezione non sia andata a buon fine.
     * @param int|null $nSala, numero della sala scelta per la proiezione. Viene restituito nel caso l'operazione di aggiunta di una sala non sia andata a buon fine.
     * @param string|null $ora, orario di inizio della proiezione. Viene restituito nel caso l'operazione di aggiunta di una sala non sia andata a buon fine.
     * @param string|null $inizio, data di inizio della proiezione. Viene restituito nel caso l'operazione di aggiunta di una sala non sia andata a buon fine.
     * @param string|null $fine, data fino alla quale verranno svolte le proieizoni. Viene restituito nel caso l'operazione di aggiunta di una sala non sia andata a buon fine.
     * @param string|null $error, esito dell'operazione.
     * @throws SmartyException
     */
    public static function gestioneProgrammazione(EUtente $utente, array $films, array $sale, EElencoProgrammazioni $programmazioni, array $locandine, $film = null, $nSala = null, $ora = null, $inizio = null, $fine = null, $error = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("utente", $utente);
        $smarty->assign("films", $films);
        $smarty->assign("sale", $sale);
        $smarty->assign("film", $film);
        $smarty->assign("programmazioni", $programmazioni);
        $smarty->assign("locandine", $locandine);
        $smarty->assign("sala", intval($nSala));
        $smarty->assign("ora", $ora);
        $smarty->assign("inizio", $inizio);
        $smarty->assign("fine", $fine);
        $smarty->assign("error", $error);

        $smarty->display("gestioneProgrammazione.tpl");
    }

    /**
     * Schermata dalla quale è possibile effettuare una modifica alla programmazione di un film.
     * @param EUtente $utente, utente che richiama la pagina.
     * @param EProgrammazioneFilm $programmazioneFilm, programmazione che si intende modificare.
     * @throws SmartyException
     */
    public static function modificaProgrammazione(EUtente $utente, EProgrammazioneFilm $programmazioneFilm) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("utente", $utente);
        $smarty->assign("programmazione", $programmazioneFilm);

        $smarty->display("modificaProgrammazione.tpl");
    }

    /**
     * Schermata che permette la modifica di una proiezione.
     * @param EUtente $utente, utente che richiede la pagina.
     * @param array $films, insieme dei film attualemnte disponibili.
     * @param array $sale, insieme delle sale fisiche presenti.
     * @param bool $cambioSala, indidica se sia possibile cambiare la sala.
     * @param EProiezione $proiezione, proiezione che si vuole modificare.
     * @throws SmartyException
     */
    public static function modificaProiezione(EUtente $utente, array $films, array $sale, bool $cambioSala, EProiezione $proiezione, $status = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path",       $GLOBALS["path"]);
        $smarty->assign("utente",     $utente);
        $smarty->assign("films",      $films);
        $smarty->assign("sale",       $sale);
        $smarty->assign("cambioSala", $cambioSala);
        $smarty->assign("proiezione", $proiezione);
        $smarty->assign("status",     $status);

        $smarty->display("modificaProiezione.tpl");
    }

    /**
     * Schermata che permette di moficare le informazioni su un film.
     * @param EFilm $film, film che si vuole modificare.
     * @param $copertina, locandina del film.
     * @throws SmartyException
     */
    public static function modificafilm(EFilm $film, $copertina, array $attori, array $registi, $errore = null){
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("film", $film);
        $smarty->assign("copertina", $copertina);
        $smarty->assign("attori", $attori);
        $smarty->assign("registi", $registi);
        $smarty->assign("generi", EGenere::getAll());
        $smarty->assign("errore", $errore);

        $smarty->display("modificaFilm.tpl");
    }
}