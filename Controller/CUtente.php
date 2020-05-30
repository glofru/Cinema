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

        if($gestore->isUsername($user)) {
            $isMail = false;
        } else if ($gestore->isEmail($user)) {
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

            try {
                $utente = new ERegistrato($nome, $cognome, $username, $email, $password, false);
            } catch (Exception $e) {
                VUtente::signup($nome, $cognome, $username, $email, $e->getMessage());
                return;
            }

            //La password ha superato il controllo di validità, quindi ne faccio l'hash
            $utente->setPassword(EHelper::getInstance()->hash($password));

            $pm = FPersistentManager::getInstance();

            if (FUtente::exists($utente, true)) {
                VUtente::signup($nome, $cognome, $username, $email, null, true);
            } elseif (FUtente::exists($utente, false)) {
                VUtente::signup($nome, $cognome, $username, $email, null, false);
            } else {
                $pm->signup($utente);
                self::saveSession($utente);
            }
        }
    }

    public static function isLogged() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION["utente"]);
    }

    public static function getUtente() {
        if(isset($_COOKIE["PHPSESSID"])) {
            session_start();
            return unserialize($_SESSION["utente"]);
        }
        else {
            return NULL;
        }

    }

}