<?php


class VRicerca
{
    public static function showResult(array $film, array $immaginiCercati, array $punteggio, array $filmConsigliati, array $immaginiConsigliati) {
        $smarty = StartSmarty::configuration();
        $smarty->assign("filmCercati", $film);
        $smarty->assign("immaginiCercati", $immaginiCercati);
        $smarty->assign("punteggio", $punteggio);
        $smarty->assign("filmConsigliati", $filmConsigliati);
        $smarty->assign("immaginiConsigliati", $immaginiConsigliati);
        $smarty->assign("genere", EGenere::getAll());
        $smarty->display("risultatiRicerca.tpl");
    }
}