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

    public static function profiloUtente($nome, $cognome , $username, $email, $img, $isbanned ) {
        $smarty = StartSmarty::configuration();
        $smarty->assign("nome", $nome);
        $smarty->assign("cognome", $cognome);
        $smarty->assign("username", $username);
        $smarty->assign("email", $email);
        $smarty->assign("img", $img);
        $smarty->assign("bannato", $isbanned);
        $smarty->display("user.tpl");

    }

    public static function showBiglietti(array $biglietti, array $immagini, EUtente $utente) {
        $smarty = StartSmarty::configuration();
        $smarty->assign("biglietti",$biglietti);
        $smarty->assign("utente", $utente);
        $smarty->assign("locandine", $immagini);
        $smarty->display("bigliettiAcquistati.tpl");
    }

    public static function gestioneUtenti(array $bannati, EAdmin $utente, int $Found = -1) {

    }
}