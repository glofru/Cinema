<?php


class VUtente
{
    public static function show(EUtente $utente, bool $canModify, EMedia $propic, $giudizi, bool $isASub = false, string $prefs = "") {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("utente", $utente);
        $smarty->assign("canModify", $canModify);
        $smarty->assign("propic", $propic);
        $smarty->assign("giudizi", $giudizi);
        $smarty->assign("isASub", $isASub);
        $smarty->assign("prefs", $prefs);

        $smarty->display("user.tpl");
    }


    public static function loginForm($username = null, bool $error = false, $checked = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign('username', $username);
        $smarty->assign('error', $error);
        $smarty->assign('checked', $checked);

        $smarty->display('login.tpl');
    }

    public static function signup($generi, string $nome = null, string $cognome = null, string $username = null, string $email = null, string $error = null, bool $emailExists = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("genere", $generi);
        $smarty->assign("path", $GLOBALS["path"]);
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

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("biglietti",$biglietti);
        $smarty->assign("utente", $utente);
        $smarty->assign("locandine", $immagini);

        $smarty->display("bigliettiAcquistati.tpl");
    }

    public static function forgotPassword($username = null, bool $ok = false) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        if ($username != null) {
            $smarty->assign('username', $username);
        }
        $smarty->assign('error', $username != null);
        $smarty->assign("ok", $ok);

        $smarty->display("forgot.tpl");
    }

    public static function showCommenti(array $giudizi, EUtente $utente, EMedia $propic) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("giudizi", $giudizi);
        $smarty->assign("utente", $utente);
        $smarty->assign("propic", $propic);

        $smarty->display("commentiUtente.tpl");
    }

    public static function newPassword(string $token, bool $error = false) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("token", $token);
        $smarty->assign("error", $error);

        $smarty->display("newPassword.tpl");
    }

    public static function showCheckNonRegsitrato(EUtente $utente, bool $isGet, string $email = "", array $biglietti = null, $immagini = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("isGet", $isGet);
        $smarty->assign("email", $email);
        $smarty->assign("biglietti", $biglietti);
        $smarty->assign("immagini", $immagini);
        $smarty->assign("utente", $utente);

        $smarty->display("bigliettiNonRegistrato.tpl");
    }

    public static function modifica(EUtente $utente, EMedia $propic, $generi, $isASub, $prefs) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("genere", $generi);
        $smarty->assign("path", $GLOBALS["path"]);
        $smarty->assign("utente", $utente);
        $smarty->assign("propic", $propic);
        $smarty->assign("prefs", $prefs);
        $smarty->assign("isASub", $isASub);
        $smarty->display("modificaUtente.tpl");
    }
}