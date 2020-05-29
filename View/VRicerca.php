<?php


class VRicerca
{
    public static function showResult(array $film, array $immaginiCercati, array $punteggio, array $filmConsigliati, array $immaginiConsigliati, $utente, $isAdmin) {
        $smarty = StartSmarty::configuration();
        $smarty->assign("filmCercati", $film);
        $smarty->assign("immaginiCercati", $immaginiCercati);
        $smarty->assign("punteggio", $punteggio);
        $smarty->assign("filmConsigliati", $filmConsigliati);
        $smarty->assign("immaginiConsigliati", $immaginiConsigliati);
        $smarty->assign("genere", EGenere::getAll());
        $smarty->assign("utente", $utente);
        $smarty->assign("isAdmin", $isAdmin);
        $smarty->display("risultatiRicerca.tpl");
    }
}