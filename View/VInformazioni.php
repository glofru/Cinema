<?php


class VInformazioni
{
    public static function getCosti($utente, bool $isAdmin) {
        $smarty = StartSmarty::configuration();
        $smarty->assign("utente", $utente);
        $smarty->assign("admin", $isAdmin);
        $smarty->assign("price", $GLOBALS["prezzi"]);
        $smarty->assign("extra", $GLOBALS["extra"]);
        $smarty->display("costi.tpl");
    }
}