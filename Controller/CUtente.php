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

    private static function checkLogin($user, $password)
    {
        $pm = FPersistentManager::getInstance();
        $gestore = EInputChecker::getInstance();

        if ($gestore->isEmail($user)) {
            $isMail = true;
        } else if ($gestore->isUsername($user)) {
            $isMail = false;
        } else {
            VUtente::loginForm($user);
            return;
        }

        $utente = $pm->login($user, $password, $isMail);
        if ($utente instanceof EUtente) {
            if ($utente->isBanned()) {
                VError::error(4);
            } else {
                self::saveSession($utente);
            }
        }
        else {
                VUtente::loginForm($user);
            }
    }

    public static function showUtente() {

        if($_SERVER['REQUEST_METHOD'] == "GET") {
            $pm = FPersistentManager::getInstance();
            $utente = self::getUtente();
            if(!isset($_GET["idShow"])){
               // header("Location: /");
                echo "NOTSET";
            }
            else
            {
                if(isset($utente) && $utente->getId() === intval($_GET["idShow"])) {
                    $canModify = true;
                    $toShow = $utente;
                } else {
                    $canModify = false;
                    $toShow = $pm->load($_GET["idShow"],"id","EUtente");
                }
                $propic = $pm->load($toShow->getId(),"idUtente","EMediaUtente");
                if($propic->getImmagine() == ""){
                    $propic->setImmagine('../../Smarty/img/user.png');
                }
                if(isset($toShow)){
                    VUtente::showUtente($toShow, $canModify, $toShow->isAdmin(), $propic);
                }
                else {
                    VError::error(0,"PROFILO UTENTE NON TROVATO!");
                }

            }
        }
    }

    public static function insertpassword()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $username = $_GET["username"];
            $password = $_POST["password"];
            self::checkLogin($username, $password);
            return true;
        } else
            {
                return false;
            }

    }

    public static function verificaUtente()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET" && self::isLogged())
        {
            $utente = self::getUtente();
            if (!isset($_GET["idShow"]))
            {
                // header("Location: /");
                echo "NOTSET";
            } else
                {
                    if (isset($utente) && $utente->getId() === intval($_GET["idShow"]))
                    {
                        return true;
                    }
                }

        }
    }

    private static function modificaUsername()
    {
        if(self::verificaUtente() == true);
        {
            $pm = FPersistentManager::getInstance();
            $username = $_POST["username"];
            if(self::insertpassword() == true)
            {
                $pm->update($_GET["username"], "username", $username, "username", "EUtente" );
            } else
            {
                VError::error(7);
            }
        }
    }

    private static function modificaNome()
    {
        if(self::verificaUtente() == true);
        {
            $pm = FPersistentManager::getInstance();
            $nome = $_POST["nome"];
            if(self::insertpassword() == true)
            {
                $pm->update($_GET["nome"], "nome", $nome, "nome", "EUtente" );
            } else
            {
                VError::error(7);
            }
        }
    }

    private static function modificaCognome()
    {
        if(self::verificaUtente() == true);
        {
            $pm = FPersistentManager::getInstance();
            $cognome = $_POST["cognome"];
            if(self::insertpassword() == true)
            {
                $pm->update($_GET["cognome"], "cognome", $cognome, "cognome", "EUtente" );
            } else
            {
                VError::error(7);
            }
        }
    }

    private static function modificaEmail()
    {
        if(self::verificaUtente() == true);
        {
            $pm = FPersistentManager::getInstance();
            $email = $_POST["email"];
            if(self::insertpassword() == true)
            {
                $pm->update($_GET["email"], "email", $email, "email", "EUtente" );
            } else
            {
                VError::error(7);
            }
        }
    }

    private static function modificaPassword()
    {
        if(self::verificaUtente() == true);
        {
            $pm = FPersistentManager::getInstance();
            $password = $_POST["password"];
            if(self::insertpassword() == true)
            {
                $pm->update($_GET["password"], "password", $password, "password", "EUtente" );
            } else
            {
                VError::error(7);
            }
        }
    }


    private static function modificaPropic($propic)
    {
        if(self::verificaUtente() == true);
        {
            $pm = FPersistentManager::getInstance();
            if(self::insertpassword() == true)
            {
                $pm->update($_GET["immagine"], "immagine", $propic, "immagine", "EMedia" );
            } else
            {
                VError::error(7);
            }
        }
    }

    private static function modificaUtente(EUtente $utente)
    {


    }




    private static function saveSession(EUtente $utente) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        session_set_cookie_params(3600, "/", null, false, true); //http only cookie, add session.cookie_httponly=On on php.ini | Andrebbe inoltre inseirto il 4° parametro
        $salvare = serialize($utente); // a TRUE per fare si che il cookie viaggi solo su HTTPS. E' FALSE perchè non abbiamo un certificato SSL ma in un contesto reale va messo a TRUE!!!
        $_SESSION['utente'] = $salvare;
        VUtente::loginOk();
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