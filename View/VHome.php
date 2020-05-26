<?php


class VHome
{
    public static function showHome($filmProssimi,$immaginiProssimi, $filmConsigliati, $immaginiConsigliati, $filmProgrammazione, $immaginiProgrammazione, $punteggioProgrammazione, $filmSettimanaScorsa,$immaginiSettimanaScorsa, $punteggioSettimanaScorsa, $filmSettimanaProssima,$immaginiSettimanaProssima, $punteggioSettimanaProssima, $username)
    {
        $smarty = StartSmarty::configuration();
        $smarty->assign("filmProssimi", $filmProssimi);
        $smarty->assign("immaginiProssimi", $immaginiProssimi);
        $smarty->assign("filmConsigliati", $filmConsigliati);
        $smarty->assign("immaginiConsigliati", $immaginiConsigliati);
        $smarty->assign("filmProgrammazione", $filmProgrammazione);
        $smarty->assign("immaginiProgrammazione", $immaginiProgrammazione);
        $smarty->assign("punteggioProgrammazione", $punteggioProgrammazione);
        $smarty->assign("filmSettimanaProssima", $filmSettimanaProssima);
        $smarty->assign("immaginiSettimanaProssima", $immaginiSettimanaProssima);
        $smarty->assign("punteggioSettimanaProssima",$punteggioSettimanaProssima);
        $smarty->assign("filmSettimanaScorsa", $filmSettimanaScorsa);
        $smarty->assign("immaginiSettimanaScorsa", $immaginiSettimanaScorsa);
        $smarty->assign("punteggioSettimanaScorsa", $punteggioSettimanaScorsa);
        $smarty->assign("user", $username);
        $smarty->display("home.tpl");
    }
}