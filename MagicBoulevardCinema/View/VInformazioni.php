<?php


class VInformazioni
{
    public static function getCosti(EUtente $utente) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("utente", $utente);
        $smarty->assign("price", $GLOBALS["prezzi"]);
        $smarty->assign("extra", $GLOBALS["extra"]);

        $smarty->display("costi.tpl");
    }

    public static function getAbout(EUtente $utente) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("utente", $utente);

        $smarty->display("about.tpl");
    }

    public static function getHelp(EUtente $utente) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("utente", $utente);

        $smarty->display("aiuto.tpl");
    }
}