<?php


class VAcquisto
{
    public static function showAcquisto(array $posti,EUtente $utente, bool $isAdmin,EProiezione $proiezione, EMediaLocandina $locandina) {
        $smarty = StartSmarty::configuration();
        $smarty->assign("utente", $utente);
        $smarty->assign("isAdmin", $isAdmin);
        $smarty->assign("proiezione", $proiezione);
        $smarty->assign("posti", $posti);
        $smarty->assign("locandina", $locandina);
        $smarty->display("acquista.tpl");
    }
}