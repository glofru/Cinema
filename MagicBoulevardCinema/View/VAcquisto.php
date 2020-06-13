<?php


class VAcquisto
{
    public static function showAcquisto(array $biglietti, EMediaLocandina $locandina, $utente, float $totale) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("biglietti", $biglietti);
        $smarty->assign("locandina", $locandina);
        $smarty->assign("utente", $utente);
        $smarty->assign("totale", $totale);

        $smarty->display("acquista.tpl");
    }
}