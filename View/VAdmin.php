<?php

class VAdmin
{
    public static function addFilm(array $attori, array $registi)
    {
        $smarty = StartSmarty::configuration();
        $smarty->assign("attori", $attori);
        $smarty->assign("registi", $registi);
        $smarty->assign("generi", EGenere::getAll());

        $smarty->display("addFilm.tpl");
    }

    public static function addProiezione(array $films, array $sale) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("films", $films);
        $smarty->assign("sale", $sale);

        $smarty->display("addProiezione.tpl");
    }

    public static function gestioneUtenti(array $bannati, EAdmin $utente, $status = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("bannati", $bannati);
        $smarty->assign("utente", $utente);
        $smarty->assign("status", $status);

        $smarty->display("gestioneUtenti.tpl");
    }

    public static function modificaPrezzo() {
        $smarty = StartSmarty::configuration();

        $smarty->assign("price", $GLOBALS["prezzi"]);
        $smarty->assign("extra", $GLOBALS["extra"]);
        $smarty->display("modificaPrezzi.tpl");
    }
}