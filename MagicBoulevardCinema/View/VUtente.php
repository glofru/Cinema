<?php

/**
 * La classe Utente permette di ottenere le schermate necessarie all'utente per poter gestire il suo account, gestire i propri giudizi, vedere i biglietti acquistati, poter effettuare il login e potersi registrare.
 * Class VUtente
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package View
 */
class VUtente
{
    /**
     * Funzione che permette di visualizzare il profilo di un utente.
     * @param EUtente $utente, utente che richiede la pagina.
     * @param bool $canModify, se l'utente sta guardando il proprio profilo allora può modificarlo.
     * @param EMedia $propic, immagine del profilo dell'utente.
     * @param $giudizi, insieme di alcuni dei giudizi espressi dall'utente di cui si sta visitando il profilo.
     * @param bool $isASub, se l'utente è iscritto alla newsletter.
     * @param string $prefs, preferenze espresse dall'utente.
     * @throws SmartyException
     */
    public static function show(EUtente $utente, bool $canModify, EMedia $propic, $giudizi, bool $isASub = false, string $prefs = "") {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path",         $GLOBALS["path"]);
        $smarty->assign("utente",       $utente);
        $smarty->assign("canModify",    $canModify);
        $smarty->assign("propic",       $propic);
        $smarty->assign("giudizi",      $giudizi);
        $smarty->assign("isASub",       $isASub);
        $smarty->assign("prefs",        $prefs);

        $smarty->display("user.tpl");
    }

    /**
     * Funzione che permette di visualizzare il form di login.
     * @param string|null $username, username o email dell'utente.
     * @param bool $error, se il login non ha avuto successo viene tornato un errore.
     * @param bool|null $checked, se l'utente ha deciso di essere ricordato.
     * @throws SmartyException
     */
    public static function loginForm($username = null, bool $error = false, $checked = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path",     $GLOBALS["path"]);
        $smarty->assign('username', $username);
        $smarty->assign('error',    $error);
        $smarty->assign('checked',  $checked);

        $smarty->display('login.tpl');
    }

    /**
     * Funzione che permette di visualizzare la pagina dove un utente possa registrarsi.
     * @param $generi, insieme dei possibili generi di un film.
     * @param string|null $nome, nome dell'utente. Viene passato se l'utente ha inserito dei parametri non validi in fase di signup e viene quindi riportato alla pagina di creazione account.
     * @param string|null $cognome, cognome dell'utente. Viene passato se l'utente ha inserito dei parametri non validi in fase di signup e viene quindi riportato alla pagina di creazione account
     * @param string|null $username, username dell'utente. Viene passato se l'utente ha inserito dei parametri non validi in fase di signup e viene quindi riportato alla pagina di creazione account
     * @param string|null $email, email dell'utente. Viene passato se l'utente ha inserito dei parametri non validi in fase di signup e viene quindi riportato alla pagina di creazione account
     * @param string|null $error, se in fase di registrazione è stato riscontrato un errore viene avvisato l'utente.
     * @param bool|null $emailExists se la mail dell'utente è già presente nel sistema.
     * @throws SmartyException
     */
    public static function signup($generi, string $nome = null, string $cognome = null, string $username = null, string $email = null, string $error = null, bool $emailExists = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("genere",           $generi);
        $smarty->assign("path",             $GLOBALS["path"]);
        if ($nome != null) {
            $smarty->assign("nome",         $nome);
        }
        if ($cognome != null) {
            $smarty->assign("cognome",      $cognome);
        }
        if ($username != null) {
            $smarty->assign("username",     $username);
        }
        if ($email != null) {
            $smarty->assign("email",        $email);
        }
        if ($error != null) {
            $smarty->assign("error",        $error);
        }
        if ($emailExists != null) {
            $smarty->assign("emailExists",  $emailExists);
        }

        $smarty->display("signup.tpl");
    }

    /**
     * Funzione che permette, ad un utente registrato, di visualizzare tutti i biglietti acquistati.
     * @param array $biglietti, insieme dei biglietti acquistati.
     * @param array $immagini, locandine dei film presenti.
     * @param EUtente $utente, utente che richiede la pagina.
     * @throws SmartyException
     */
    public static function showBiglietti(array $biglietti, array $immagini, EUtente $utente) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path",         $GLOBALS["path"]);
        $smarty->assign("biglietti",    $biglietti);
        $smarty->assign("utente",       $utente);
        $smarty->assign("locandine",    $immagini);

        $smarty->display("bigliettiAcquistati.tpl");
    }

    /**
     * Funzione che permette di visualizzare la schermata dove inserire la propria mail per poter resettare la propria password.
     * @param string|null $username, viene restitituita la mail inserita dopo aver eseguito la richiesta.
     * @param bool $ok, se la mail è presente realmente nel nostro DB.
     * @throws SmartyException
     */
    public static function forgotPassword($username = null, bool $ok = false) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path",         $GLOBALS["path"]);
        if ($username != null) {
            $smarty->assign('username', $username);
        }
        $smarty->assign('error',        $username != null);
        $smarty->assign("ok",           $ok);

        $smarty->display("forgot.tpl");
    }

    /**
     * Funzione che permette di mostrare i giudizi espressi dall'utente.
     * @param array $giudizi, insieme dei giudizi.
     * @param EUtente $utente, utente che ha richiesto la pagina e che ha espresso i giudizi.
     * @param EMedia $propic, immagine del profilo dell'utente.
     * @throws SmartyException
     */
    public static function showCommenti(array $giudizi, EUtente $utente, EMedia $propic) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path",     $GLOBALS["path"]);
        $smarty->assign("giudizi",  $giudizi);
        $smarty->assign("utente",   $utente);
        $smarty->assign("propic",   $propic);

        $smarty->display("commentiUtente.tpl");
    }

    /**
     * Funzione che permette di mostrare la schermata dove inserire la nuova password dopo aver chiesto il reset.
     * @param string $token, token di richiesta del reset password.
     * @param bool $error, nel caso ci sia un errore nell'effettuare l'operazione.
     * @throws SmartyException
     */
    public static function newPassword(string $token, bool $error = false) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path",     $GLOBALS["path"]);
        $smarty->assign("token",    $token);
        $smarty->assign("error",    $error);

        $smarty->display("newPassword.tpl");
    }

    /**
     * Funzione che permette di visualizzare la schermata di login per utenti non registrati. Se effettuato il login mostra i biglietti acquistati dall'utente.
     * @param EUtente $utente, utente che richiede la pagina.
     * @param bool $isGet, se è richiesta la pagina in GET (form di login) o in POST (insieme dei biglietti acquistati).
     * @param string $email, email dell'utente.
     * @param array|null $biglietti, insieme dei biglietti acquistati.
     * @param null $immagini, locandine dei film.
     * @throws SmartyException
     */
    public static function showCheckNonRegsitrato(EUtente $utente, bool $isGet, string $email = "", array $biglietti = null, $immagini = null) {
        $smarty = StartSmarty::configuration();

        $smarty->assign("path",         $GLOBALS["path"]);
        $smarty->assign("isGet",        $isGet);
        $smarty->assign("email",        $email);
        $smarty->assign("biglietti",    $biglietti);
        $smarty->assign("immagini",     $immagini);
        $smarty->assign("utente",       $utente);

        $smarty->display("bigliettiNonRegistrato.tpl");
    }

    /**
     * Funzione che permette di mostrare la schermata di modifica dei dati dell'utente.
     * @param EUtente $utente, utente che richiede la pagina.
     * @param EMedia $propic, immagine di profilo dell'utente.
     * @param $generi, insieme di tutti i generi dei film.
     * @param $isASub, se l'utente è iscritto alla newsletter.
     * @param $prefs, le preferenze espresse dall'utente iscritto alla newsletter.
     * @throws SmartyException
     */
    public static function modifica(EUtente $utente, EMedia $propic, $generi, $isASub, $prefs, $errore = "") {
        $smarty = StartSmarty::configuration();

        $smarty->assign("genere",   $generi);
        $smarty->assign("path",     $GLOBALS["path"]);
        $smarty->assign("utente",   $utente);
        $smarty->assign("propic",   $propic);
        $smarty->assign("prefs",    $prefs);
        $smarty->assign("errore",   $errore);
        $smarty->assign("isASub",   $isASub);

        $smarty->display("modificaUtente.tpl");
    }
}