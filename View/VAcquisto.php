<?php


class VAcquisto
{
    public static function showAcquisto(array $biglietti, EMediaLocandina $locandina, EUtente $utente) {
        $smarty = StartSmarty::configuration();
        $smarty->assign("biglietti", $biglietti);
        $smarty->assign("locandina", $locandina);
        $smarty->assign("utente", $utente);
        $smarty->display("acquista.tpl");
    }
}