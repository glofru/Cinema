<?php


class VHome
{
    private $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    public function showHome($filmProssimi,$immaginiProssimi, $filmConsigliati, $immaginiConsigliati, $filmProgrammazione, $immaginiProgrammazione, $punteggioProgrammazione, $filmSettimanaScorsa,$immaginiSettimanaScorsa, $punteggioSettimanaScorsa, $filmSettimanaProssima,$immaginiSettimanaProssima, $punteggioSettimanaProssima, $username)
    {
        $this->smarty->assign("filmProssimi", $filmProssimi);
        $this->smarty->assign("immaginiProssimi",$immaginiProssimi);
        $this->smarty->assign("filmConsigliati", $filmConsigliati);
        $this->smarty->assign("immaginiConsigliati",$immaginiConsigliati);
        $this->smarty->assign("filmProgrammazione", $filmProgrammazione);
        $this->smarty->assign("immaginiProgrammazione",$immaginiProgrammazione);
        $this->smarty->assign("punteggioProgrammazione", $punteggioProgrammazione);
        $this->smarty->assign("filmSettimanaProssima", $filmSettimanaProssima);
        $this->smarty->assign("immaginiSettimanaProssima",$immaginiSettimanaProssima);
        $this->smarty->assign("punteggioSettimanaProssima",$punteggioSettimanaProssima);
        $this->smarty->assign("filmSettimanaScorsa", $filmSettimanaScorsa);
        $this->smarty->assign("immaginiSettimanaScorsa",$immaginiSettimanaScorsa);
        $this->smarty->assign("punteggioSettimanaScorsa",$punteggioSettimanaScorsa);
        $this->smarty->assign("user",$username);
        $this->smarty->display("home.tpl");
    }
}