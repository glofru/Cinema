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
    public function visualizzalogin(){
        $smarty = StartSmarty::configuration();
        if (isset($_POST['conveyor']))
            $smarty->assign('email',$_POST['conveyor']);
        $smarty->display('login.tpl');
    }
    public function profiloutente() {
        $smarty = StartSmarty::configuration();

    }
    public function registra_cliente() {
        $smarty = StartSmarty::configuration();
        $smarty->display('registrazionecliente.tpl');
    }
}