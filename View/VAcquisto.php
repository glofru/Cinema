<?php


class VAcquisto
{
    public static function showAcquisto(array $biglietti, bool $isAdmin, EMediaLocandina $locandina, string $serialized) {
        $smarty = StartSmarty::configuration();
        $smarty->assign("biglietti", $biglietti);
        $smarty->assign("isAdmin", $isAdmin);
        $smarty->assign("locandina", $locandina);
        $smarty->assign("serialized", $serialized);
        $smarty->display("acquista.tpl");
    }
}