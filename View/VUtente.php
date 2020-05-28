<?php


class VUtente
{
    public static function showUtente(EUtente $utente)
    {
        $smarty = StartSmarty::configuration();
        $smarty->assign("utente", $utente);
        $smarty->display("user.tpl");
    }
    public static function loginError($username) {
        $smarty = StartSmarty::configuration();
        $smarty->assign('username', $username);
        $smarty->assign('error',"errore");
        $smarty->display('login.tpl');
    }
    public static function loginOk() {
        header("Location: /");
//        $smarty = StartSmarty::configuration();
//        $smarty->assign('immagine', "/Cinema/Smarty/immagini/bb3b.png");
//        $smarty->assign('userlogged',"loggato");
//        $smarty->display('home.tpl');
    }
    public static function visualizzaLogin(){
        $smarty = StartSmarty::configuration();
        if (isset($_POST['conveyor']))
            $smarty->assign('email',$_POST['conveyor']);
        $smarty->display('login.tpl');
    }
    public static function profiloUtente() {
        $smarty = StartSmarty::configuration();

    }

    public static function loginForm() {
        $smarty = StartSmarty::configuration();
        $smarty->display('login.tpl');
    }
}