<?php

/**
 * La classe Informazioni permette di mostrare alcune schermate contenenti delle informazioni sul nostro sito (costi dei biglietti, informazioni su di noi e pagina di aiuto).
 * Class VInformazioni
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package View
 */
class VInformazioni
{
    /**
     * Funzione che permette di visualizzare la schermata con i costi dei biglietti e della sovrattassa applicata dal cinema.
     * @param EUtente $utente, utente che richiede la pagina.
     * @throws SmartyException
     */
    public static function getCosti(EUtente $utente) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path",     $GLOBALS["path"]);
        $smarty->assign("utente",   $utente);
        $smarty->assign("price",    $GLOBALS["prezzi"]);
        $smarty->assign("extra",    $GLOBALS["extra"]);

        $smarty->display("costi.tpl");
    }

    /**
     * Funzione che permette di ottenere la pagina con le informazioni sul nostro sito.
     * @param EUtente $utente, utente che richiede la pagina.
     * @throws SmartyException
     */
    public static function getAbout(EUtente $utente) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path",     $GLOBALS["path"]);
        $smarty->assign("utente",   $utente);

        $smarty->display("about.tpl");
    }

    /**
     * Funzione che mostra la pagina di aiuto.
     * @param EUtente $utente, utente che richiede la pagina.
     * @throws SmartyException
     */
    public static function getHelp(EUtente $utente) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path",     $GLOBALS["path"]);
        $smarty->assign("utente",   $utente);

        $smarty->display("aiuto.tpl");
    }
}