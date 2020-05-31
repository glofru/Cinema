<?php


class VHome
{
    public static function showHome($filmProssimi, $immaginiProssimi, $filmConsigliati, $immaginiConsigliati, $filmProgrammazione, $immaginiProgrammazione, $punteggioProgrammazione, $dateProgrammazione, $filmSettimanaScorsa,$immaginiSettimanaScorsa, $punteggioSettimanaScorsa, $dateSettimanaScorsa, $filmSettimanaProssima,$immaginiSettimanaProssima, $punteggioSettimanaProssima, $dateSettimanaProssima, $utente, $isAdmin)
    {
        $smarty = StartSmarty::configuration();
        $smarty->assign("filmProssimi", $filmProssimi);
        $smarty->assign("immaginiProssimi", $immaginiProssimi);
        $smarty->assign("filmConsigliati", $filmConsigliati);
        $smarty->assign("immaginiConsigliati", $immaginiConsigliati);
        $smarty->assign("filmProgrammazione", $filmProgrammazione);
        $smarty->assign("immaginiProgrammazione", $immaginiProgrammazione);
        $smarty->assign("punteggioProgrammazione", $punteggioProgrammazione);
        $smarty->assign("dateProgrammazione", $dateProgrammazione);
        $smarty->assign("filmSettimanaProssima", $filmSettimanaProssima);
        $smarty->assign("immaginiSettimanaProssima", $immaginiSettimanaProssima);
        $smarty->assign("punteggioSettimanaProssima",$punteggioSettimanaProssima);
        $smarty->assign("dateSettimanaProssima", $dateSettimanaProssima);
        $smarty->assign("filmSettimanaScorsa", $filmSettimanaScorsa);
        $smarty->assign("immaginiSettimanaScorsa", $immaginiSettimanaScorsa);
        $smarty->assign("punteggioSettimanaScorsa", $punteggioSettimanaScorsa);
        $smarty->assign("dateSettimanaScorsa", $dateSettimanaScorsa);
        $smarty->assign("utente", $utente);
        $smarty->assign("admin", $isAdmin);
        $smarty->display("home.tpl");
    }
}