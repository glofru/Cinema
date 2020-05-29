<?php


class VUtente
{
    public static function showUtente(EUtente $utente)
    {
        $smarty = StartSmarty::configuration();
        $smarty->assign("utente", $utente);
        $smarty->display("user.tpl");
    }

    public static function loginForm($username = null) {
        $smarty = StartSmarty::configuration();
        
        if ($username != null) {
            $smarty->assign('username', $username);
        }
        $smarty->assign('error', $username != null);

        $smarty->display('login.tpl');
    }

    public static function loginOk() {
        header("Location: /");
//        $smarty = StartSmarty::configuration();
//        $smarty->assign('immagine', "/Cinema/Smarty/immagini/bb3b.png");
//        $smarty->assign('userlogged',"loggato");
//        $smarty->display('home.tpl');
    }

    public static function signup($nome = null, $cognome = null, $username = null, $email = null, $emailExists = false, $usernameExists = false) {
        $smarty = StartSmarty::configuration();

        if ($nome != null) {
            $smarty->assign("nome", $nome);
        }
        if ($cognome != null) {
            $smarty->assign("cognome", $cognome);
        }
        if ($username != null) {
            $smarty->assign("username", $username);
        }
        if ($email != null) {
            $smarty->assign("email", $email);
        }
        $smarty->assign("emailExists", $emailExists);
        $smarty->assign("usernameExists", $usernameExists);

        $smarty->display("signup.tpl");
    }

    public static function profiloUtente() {
        $smarty = StartSmarty::configuration();

    }
}