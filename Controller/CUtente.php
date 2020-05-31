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

        if($gestore->isEmail($user)) {
            $isMail = true;
        } else if ($gestore->isUsername($user)) {
            $isMail = false;
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

    static function mostraprofilo(EUtente $utente) {
        $view = new VUtente();
        $pm = FPersistentManager::getInstance();
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUtente::isLogged())
            {
                if ($pm->load($utente->getId(), "isBanned", "FMedia")== false)
                {
                    $img = $pm->load($utente->getId(), "immagine", "FMedia");
                    $nome = $pm->load($utente->getId(), "nome", "FUtente");
                    $cognome = $pm->load($utente->getId(), "cognome", "FUtente");
                    $username = $pm->load($utente->getId(), "username", "FUtente");
                    $email = $pm->load($utente->getId(), "email", "FUtente");
                    $isBanned = $pm->load($utente->getId(), "isBanned", "FMedia");
                    $view->profiloUtente($nome, $cognome, $username, $email, $img, $isBanned);

                } else {
                    VError::error(3);
                }


            } else
                header('Location: /FillSpaceWEB/Utente/login');
        }
    }



    private static function saveSession(EUtente $utente) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        session_set_cookie_params(3600, "/", null, false, true); //http only cookie, add session.cookie_httponly=On on php.ini | Andrebbe inoltre inseirto il 4° parametro
        $salvare = serialize($utente); // a TRUE per fare si che il cookie viaggi solo su HTTPS. E' FALSE perchè non abbiamo un certificato SSL ma in un contesto reale va messo a TRUE!!!
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
        return isset($_COOKIE["PHPSESSID"]);
    }

    public static function getUtente() {
        if(self::isLogged()) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            return unserialize($_SESSION["utente"]);
        }

        return NULL;
    }

    public static function bigliettiAcquistati() {
        $utente = self::getUtente();
        if(!isset($utente) || $utente->isAdmin()) {
            header("Location: /");
        }
        $biglietti = FPersistentManager::getInstance()->load($utente->getId(),"idUtente","EBiglietto");
        $immagini = [];
        foreach ($biglietti as $item) {
            array_push($immagini,FPersistentManager::getInstance()->load($item->GetProiezione()->getFilm()->getId(), "idFilm", "EMedia"));
        }
        VUtente::showBiglietti($biglietti, $immagini, $utente);
    }

}