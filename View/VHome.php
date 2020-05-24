<?php


class VHome
{
    private $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    public function showHome($filmProssimi,$immaginiProssimi, $filmConsigliati, $immaginiConsigliati, $filmProgrammazione, $immaginiProgrammazione, $username)
    {
        $this->smarty->assign("filmProssimi", $filmProssimi);
        $this->smarty->assign("immaginiProssimi",$immaginiProssimi);
        $this->smarty->assign("filmConsigliati", $filmConsigliati);
        $this->smarty->assign("immaginiConsigliati",$immaginiConsigliati);
        $this->smarty->assign("filmProgrammazione", $filmProgrammazione);
        $this->smarty->assign("immaginiProgrammazione",$immaginiProgrammazione);
        $this->smarty->assign("user",$username);
        $this->smarty->display("home.tpl");
    }
}