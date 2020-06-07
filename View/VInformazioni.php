<?php


class VInformazioni
{
    public static function getCosti($utente, bool $isAdmin) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("utente", $utente);
        $smarty->assign("admin", $isAdmin);
        $smarty->assign("price", $GLOBALS["prezzi"]);
        $smarty->assign("extra", $GLOBALS["extra"]);

        $smarty->display("costi.tpl");
    }

    public static function getAbout($utente, bool $isAdmin) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("utente", $utente);
        $smarty->assign("admin", $isAdmin);

        $smarty->display("about.tpl");
    }

    public static function getHelp($utente, bool $isAdmin) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("utente", $utente);
        $smarty->assign("admin", $isAdmin);

        $smarty->display("aiuto.tpl");
    }
}