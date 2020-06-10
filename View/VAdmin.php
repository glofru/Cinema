<?php

class VAdmin
{
    public static function addFilm(array $attori, array $registi)
    {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("attori", $attori);
        $smarty->assign("registi", $registi);
        $smarty->assign("generi", EGenere::getAll());

        $smarty->display("addFilm.tpl");
    }

//    public static function addProiezione(array $films, array $sale) {
//        $smarty = StartSmarty::configuration();
//
//        $smarty->assign("path", $GLOBALS["path"]);
//        $smarty->assign("films", $films);
//        $smarty->assign("sale", $sale);
//
//        $smarty->display("addProiezione.tpl");
//    }

    public static function gestioneUtenti(array $bannati, EAdmin $utente, $status = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("bannati", $bannati);
        $smarty->assign("utente", $utente);
        $smarty->assign("status", $status);

        $smarty->display("gestioneUtenti.tpl");
    }

    public static function modificaPrezzo() {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("price", $GLOBALS["prezzi"]);
        $smarty->assign("extra", $GLOBALS["extra"]);

        $smarty->display("modificaPrezzi.tpl");
    }

    public static function gestioneSale(array $sale, EUtente $utente, $e = null, $nSala = null, $nFile = null, $nPosti = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("sale", $sale);
        $smarty->assign("utente", $utente);
        $smarty->assign("status", $e);
        $smarty->assign("nSala", $nSala);
        $smarty->assign("nFile", $nFile);
        $smarty->assign("nPosti", $nPosti);

        $smarty->display("gestioneSale.tpl");
    }

    public static function gestioneProiezioni(EUtente $utente) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("utente", $utente);

        $smarty->display("gestionePrenotazioni.tpl");
    }

    public static function modificafilm(EFilm $film, $copertina){
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("film", $film);
        $smarty->assign("copertina", $copertina);
        $smarty->assign("generi", EGenere::getAll());

        $smarty->display("modificaFilm.tpl");
    }
}