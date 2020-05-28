<?php


class VUtente
{
    public static function showUtente(EUtente $utente)
    {
        $smarty = StartSmarty::configuration();
        $smarty->assign("utente", $utente);
        $smarty->display("user.tpl");
    }
    public static function loginError() {
        $smarty = StartSmarty::configuration();
        $smarty->assign('error',"errore");
        $smarty->display('login.tpl');
    }
    public static function loginOk() {
        $smarty = StartSmarty::configuration();
        $smarty->assign('immagine', "/Cinema/Smarty/immagini/bb3b.png");
        $smarty->assign('userlogged',"loggato");
        $smarty->display('home.tpl');
    }
    public static function visualizzalogin(){
        $smarty = StartSmarty::configuration();
        if (isset($_POST['conveyor']))
            $smarty->assign('email',$_POST['conveyor']);
        $smarty->display('login.tpl');
    }
    public static function profiloutente() {
        $smarty = StartSmarty::configuration();

    }
    public static function registra_cliente() {
        $smarty = StartSmarty::configuration();
        $smarty->display('registrazionecliente.tpl');
    }

    public static function loginForm() {
        $smarty = StartSmarty::configuration();
        $smarty->display('login.tpl');
    }
}