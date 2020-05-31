<?php


class VUtente
{
    public static function showUtente(EUtente $utente, bool $canModify, bool $isAdmin)
    {
        $smarty = StartSmarty::configuration();
        $smarty->assign("utente", $utente);
        $smarty->assign("canModify", $canModify);
        $smarty->assign("admin", $isAdmin);
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

    public static function signup(string $nome = null, string $cognome = null, string $username = null, string $email = null, string $error = null, bool $emailExists = null) {
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
        if ($error != null) {
            $smarty->assign("error", $error);
        }
        if ($emailExists != null) {
            $smarty->assign("emailExists", $emailExists);
        }

        $smarty->display("signup.tpl");
    }

    public static function showBiglietti(array $biglietti, array $immagini, EUtente $utente) {
        $smarty = StartSmarty::configuration();
        $smarty->assign("biglietti",$biglietti);
        $smarty->assign("utente", $utente);
        $smarty->assign("locandine", $immagini);
        $smarty->display("bigliettiAcquistati.tpl");
    }
}