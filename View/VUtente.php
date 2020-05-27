<?php


class VUtente
{
    public static function showUtente(EUtente $utente)
    {
        $smarty = StartSmarty::configuration();
        $smarty->assign("utente", $utente);
        $smarty->display("user.tpl");
    }
    public function loginError() {
        $smarty = StartSmarty::configuration();
        $smarty->assign('error',"errore");
        $smarty->display('login.tpl');
    }
    public function loginOk() {
        $smarty = StartSmarty::configuration();
        $smarty->assign('immagine', "/Cinema/Smarty/immagini/bb3b.png");
        $smarty->assign('userlogged',"loggato");
        $smarty->display('home.tpl');
    }
}