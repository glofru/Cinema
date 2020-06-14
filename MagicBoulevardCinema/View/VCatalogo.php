<?php

/**
 * La classe Catalogo contiene tutti i medoti necessari a mostrare le schermate contenenti i film i prossima usciti, i film presenti nelle programmazioni passate ed i film più apprezzati dall'utenza.
 * Class VCatalogo
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package View
 */
class VCatalogo
{

    /**
     * Funzione che permette di mostrare i film in prossima uscita.
     * @param array $result, array contenente i film e le locandine.
     * @param $utente, utente che richiede la pagina.
     * @param array $consigliati, insieme dei film e delle locandine dei film consigliati all'utente.
     * @throws SmartyException
     */
    public static function prossimeUscite(array $result, $utente, array $consigliati) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path",                 $GLOBALS["path"]);
        $smarty->assign("filmProssimi",         $result[0]);
        $smarty->assign("immaginiProssimi",     $result[1]);
        $smarty->assign("utente",               $utente);
        $smarty->assign("filmConsigliati",      $consigliati[0]);
        $smarty->assign("immaginiConsigliati",  $consigliati[1]);
        $smarty->assign("whois",                "Prossime uscite");

        $smarty->display("catalogo.tpl");
    }

    /**
     * Funzione che permette di mostrare le programmazioni che il cinema ha proposto nell'inervallo 2 - 6 settimane fa.
     * @param array $film, insieme dei film presenti.
     * @param array $immagini, locandine dei film.
     * @param array $punteggio, media voti degli utenti di ogni film.
     * @param array $date, insieme contenente gli intervalli di date che identificano le rispettive settimane.
     * @param $utente, utente che richiede la pagina.
     * @param array $consigliati, insieme dei film consigliati e le rispettive locandine.
     * @param array $toShow, stringa di intestazione.
     * @throws SmartyException
     */
    public static function programmazioniPassate(array $film, array $immagini, array $punteggio, array $date, $utente, array $consigliati, array $toShow) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path",                 $GLOBALS["path"]);
        $smarty->assign("utente",               $utente);
        $smarty->assign("filmPassati",          $film);
        $smarty->assign("immaginiPassati",      $immagini);
        $smarty->assign("punteggio",            $punteggio);
        $smarty->assign("date",                 $date);
        $smarty->assign("whois",                "Programmazioni delle ultime settimane");
        $smarty->assign("filmConsigliati",      $consigliati[0]);
        $smarty->assign("immaginiConsigliati",  $consigliati[1]);
        $smarty->assign("toShow",               $toShow);

        $smarty->display("catalogo.tpl");
    }

    /**
     * Funzioen che permette di vedere la top 10 dei film più apprezzati dagli utenti.
     * @param array $result, insieem di film e locandine.
     * @param $utente, utente che richiede la pagina.
     * @param array $consigliati, insieme dei film consigliati e delle rispettive locandine.
     * @throws SmartyException
     */
    public static function piuApprezzati(array $result, $utente, array $consigliati) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path",                 $GLOBALS["path"]);
        $smarty->assign("utente",               $utente);
        $smarty->assign("filmApprezzati",       $result[0]);
        $smarty->assign("immaginiApprezzati",   $result[1]);
        $smarty->assign("punteggio",            $result[2]);
        $smarty->assign("filmConsigliati",      $consigliati[0]);
        $smarty->assign("immaginiConsigliati",  $consigliati[1]);
        $smarty->assign("whois",                "Top 10 film più apprezzati dagli utenti");

        $smarty->display("catalogo.tpl");
    }
}