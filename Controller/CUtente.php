<?php


class CUtente
{
    public static function login() {
        if (self::isLogged()) {
            header("Location: /");
        } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
            VUtente::loginForm();
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];
            self::checkLogin($username, $password);
        }
    }
    
    static function logout() {
        if(isset($_COOKIE["PHPSESSID"])) {
            session_start();
            session_unset();
            session_destroy();
            setcookie("PHPSESSID", "", time() - 3600,"/");
        }

        header("Location: /");
    }

    private static function checkLogin($user, $password) {
        $pm = FPersistentManager::getInstance();
        $gestore = EInputChecker::getInstance();

        if($user === $gestore->username($user)) {
            $isMail = false;
        } else if ($user === $gestore->email($user)) {
            $isMail = true;
        } else {
            VUtente::loginForm($user);
            return;
        }

        $utente = $pm->login($user, $password, $isMail);

        if ($utente instanceof EUtente) {
            self::saveSession($utente);
        } else {
            VUtente::loginForm($user);
        }
    }
    
//    public static function mostraProfilo() {
//        $view = new VUtente();
//        $pm = FPersistentManager::getInstance();
//        if($_SERVER['REQUEST_METHOD'] == "GET") {
//            if (CUtente::isloggato()) {
//                $utente = unserialize($_SESSION['utente']);
//                if (get_class($utente) == "ERegistrato") {
//                    $img = $pm->load("emailutente", $utente->getEmail(), "FUtente");
//                    $annunci = $pm->load("emailWriter", $utente->getEmail(), "FAnnuncio");
//                    $view->profileCli($utente, $annunci, $img);
//                } else {
//                    $img = $pm->load("emailutente", $utente->getEmail(), "FMediaUtente");
//                    $annunci = $pm->load("emailWriter", $utente->getEmail(), "FAnnuncio");
//                    list ($imgMezzo,$imgrecensioni) = static::set_profilo_tra($utente);
//                    $rec = static::info_cliente_rec($utente);
//                    $view->profileTrasp($utente, $annunci, $img, $imgMezzo, $imgrecensioni,$rec);
//                }
//            } else {
//                header('Location: /Cinema/Utente/login');
//            }
//        }
//    }

    private static function saveSession(EUtente $utente) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        session_regenerate_id(true);
        session_set_cookie_params(3600, "/", null, false, true); //http only cookie, add session.cookie_httponly=On on php.ini
        $salvare = serialize($utente);
        $_SESSION['utente'] = $salvare;
        /*if ($utente->isAdmin() === true) {
            header('Location: /Cinema/Home');
        }
        else {*/
            VUtente::loginOk();
        //}
    }

    private static function checkSignupData(): bool {
        //TODO
        return true;
    }

    public static function signup() {
        if (self::isLogged()) {
            header("Location: /");
        } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
            VUtente::signup();
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST["nome"];
            $cognome = $_POST["cognome"];
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            if (self::checkSignupData()) {
                $pm = FPersistentManager::getInstance();

                if ($pm->existsUser($username, false)) {
                    VUtente::signup($nome, $cognome, $username, $email, false, true);
                } elseif ($pm->existsUser($email, true)) {
                    VUtente::signup($nome, $cognome, $username, $email, true, false);
                } else {
                    $password = self::hash($password);
                    $utente = new ERegistrato($nome, $cognome, $username, $email, $password, false);
                    $pm->signup($utente);
                    self::saveSession($utente);
                }
            } else {
                VUtente::signup($nome, $cognome, $username, $email);
            }
        }
//        if($_SERVER['REQUEST_METHOD']=="GET") {
//            $view = new VUtente();
//            $pm = FPersistentManager::getInstance();
//            if (static::checkLogin()) {
//                $pm->load();
//            }
//            else {
//                $view->registra_cliente();
//            }
//        }else if($_SERVER['REQUEST_METHOD']=="POST") {
//
//        }
    }

    private static function hash($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function isLogged() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION["utente"]);
    }

}