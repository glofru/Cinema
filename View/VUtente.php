<?php


class VUtente
{

    private Smarty $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    public function showUtente(EUtente $utente)
    {
        $this->smarty->assign("utente", $utente);
        $this->smarty->display("user.tpl");
    }
}