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

    public static function gestioneProgrammazione(EUtente $utente, array $films, array $sale, EElencoProgrammazioni $programmazioni, array $locandine, $film = null, $nSala = null, $ora = null, $inizio = null, $fine = null, $error = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("utente", $utente);
        $smarty->assign("films", $films);
        $smarty->assign("sale", $sale);
        $smarty->assign("film", $film);
        $smarty->assign("programmazioni", $programmazioni);
        $smarty->assign("locandine", $locandine);
        $smarty->assign("sala", intval($nSala));
        $smarty->assign("ora", $ora);
        $smarty->assign("inizio", $inizio);
        $smarty->assign("fine", $fine);
        $smarty->assign("error", $error);

        $smarty->display("gestioneProgrammazione.tpl");
    }

    public static function modificaProgrammazione(EUtente $utente, EProgrammazioneFilm $programmazioneFilm) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("utente", $utente);
        $smarty->assign("programmazione", $programmazioneFilm);

        $smarty->display("modificaProgrammazione.tpl");
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