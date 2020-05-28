<?php


class CUtente
{
    public static function login() {
        if (self::isLogged()) {
            header("Location: /");
        } else {
            VUtente::loginForm();
        }
    }

    public static function tryLogin() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            self::checkLogin($_POST["username"], $_POST["password"]);
        } else {
            self::login();
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
            VUtente::loginError($user);
            return;
        }

        $utente = $pm->login($user, $password, $isMail);
        if (sizeof($utente) != 0) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
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
            } else {
                VUtente::loginError($utente);
            }
        } else {
            VUtente::loginError($utente);
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

    public static function registrazione() {
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

    public static function isLogged() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION["utente"]);
    }

}