<?php


class VRicerca
{
    public static function showResult(array $film, array $immaginiCercati, array $punteggio, array $filmConsigliati, array $immaginiConsigliati, $utente, $isAdmin, $genere = null, $annoInizio = null, $annoFine =null, $votoInizio = null, $votoFine = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("filmCercati", $film);
        $smarty->assign("immaginiCercati", $immaginiCercati);
        $smarty->assign("punteggio", $punteggio);
        $smarty->assign("filmConsigliati", $filmConsigliati);
        $smarty->assign("immaginiConsigliati", $immaginiConsigliati);
        $smarty->assign("generi", EGenere::getAll());
        $smarty->assign("genere", $genere);
        $smarty->assign("annoInizio", $annoInizio);
        $smarty->assign("annoFine", $annoFine);
        $smarty->assign("votoInizio", $votoInizio);
        $smarty->assign("votoFine", $votoFine);
        $smarty->assign("utente", $utente);
        $smarty->assign("admin", $isAdmin);

        $smarty->display("risultatiRicerca.tpl");
    }
}