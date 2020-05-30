<?php


class VAcquisto
{
    public static function showAcquisto(array $biglietti, bool $isAdmin, EMediaLocandina $locandina, EUtente $utente) {
        $smarty = StartSmarty::configuration();
        $smarty->assign("biglietti", $biglietti);
        $smarty->assign("isAdmin", $isAdmin);
        $smarty->assign("locandina", $locandina);
        $smarty->assign("utente", $utente);
        $smarty->display("acquista.tpl");
    }
}