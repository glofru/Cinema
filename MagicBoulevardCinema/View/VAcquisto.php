<?php

/**
 * la Classe Acquisto contiene il metodo necessario a mostrare la schermata riassuntiva dell'acquisto che l'utente sta eseguendo.
 * Class VAcquisto
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package View
 */
class VAcquisto
{
    /**
     * Funzione che permette di vsiualizzare la schermata riassuntiva dei biglietti che l'utente intende acquistare.
     * @param array $biglietti, insieme dei biglietti che si vuole acquistare.
     * @param EMediaLocandina $locandina, locandina del film per il quale si stanno acquistando i biglietti.
     * @param $utente, utente che effettua l'acquisto.
     * @param float $totale, costo totale dei biglietti.
     * @throws SmartyException
     */
    public static function showAcquisto(array $biglietti, EMediaLocandina $locandina, $utente, float $totale) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path",      $GLOBALS["path"]);
        $smarty->assign("biglietti", $biglietti);
        $smarty->assign("locandina", $locandina);
        $smarty->assign("utente",    $utente);
        $smarty->assign("totale",    $totale);

        $smarty->display("acquista.tpl");
    }
}