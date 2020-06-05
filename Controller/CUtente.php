<?php


class CUtente
{
    public static function login() {
        if (self::isLogged()) {
            header("Location: /");
        } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
            if(isset($_COOKIE["remember"])){
                VUtente::loginForm($_COOKIE["remember"], false, 1);
            } else {
                VUtente::loginForm();
            }

        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];
            if(isset($_POST["remember"])) {
                setcookie("remember", $username, time() + time() + (168 * 3600),"/");
            } else {
                setcookie("remember", "", time() + time() - (168 * 3600),"/");
            }
            self::checkLogin($username, $password);
        }
    }

    public static function loginNonRegistrato() {
        if(self::isLogged()){
            header("Location: /");
        } else if ($_SERVER["REQUEST_METHOD"] == "POST" && EInputChecker::getInstance()->isEmail($_POST["email"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $utente = FPersistentManager::getInstance()->login($email, $password, true);
            if(!isset($utente)) {
                VUtente::showCheckNonRegsitrato(true, $email);
            } else if($utente->isRegistrato()) {
                VError::error(0, "Pagina destinata ad utenti non Registrati");
            } else {
                foreach (FPersistentManager::getInstance()->load($utente->getId(), "idUtente", "EBiglietto") as $b) {
                    $utente->addBiglietto($b);
                }

                $biglietti = $utente->getListaBiglietti();

                usort($biglietti, array(EHelper::getInstance(), "sortByDatesBiglietti"));
                $immagini = [];

                foreach ($biglietti as $item) {
                    array_push($immagini,FPersistentManager::getInstance()->load($item->GetProiezione()->getFilm()->getId(), "idFilm", "EMedia"));
                }

                VUtente::showCheckNonRegsitrato(false, $email, $biglietti, $immagini);
            }
        } else {
            CMain::methodNotAllowed();
        }
    }
    
    public static function logout($redirect = true) {
        if(isset($_COOKIE["PHPSESSID"])) {
            session_start();
            session_unset();
            session_destroy();
            setcookie("PHPSESSID", "", time() - 3600,"/");
        }
        if($redirect) {
            header("Location: /");
        }
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
            VUtente::loginForm($user, true);
            return;
        }

        $utente = $pm->login($user, $password, $isMail);

        if ($utente instanceof EUtente) {
            if ($utente->isBanned()) {
                VError::error(4);
            } else {
                $biglietti = $pm->load($utente->getId(), "idUtente", "EBiglietto");
                foreach ($biglietti as $b) {
                    $utente->addBiglietto($b);
                }
                self::saveSession($utente);
            }
        } else {
            VUtente::loginForm($user, true);
        }
    }

    public static function show() {
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if(!isset($_GET["id"])){
                CMain::notFound();
            } else {
                $pm = FPersistentManager::getInstance();

                if(CUtente::isLogged() && CUtente::getUtente()->getId() === intval($_GET["id"])) {
                    $canModify = true;
                    $toShow = CUtente::getUtente();
                } else {
                    $canModify = false;
                    $toShow = $pm->load($_GET["id"],"id","EUtente");
                    if(isset($toShow) && !$toShow->isAdmin()) {
                        $giudizi = $pm->load($_GET["id"], "idUtente", "EGiudizio");
                        foreach ($giudizi as $g) {
                            $toShow->addGiudizio($g);
                        }
                     }
                }

                $propic = $pm->load($toShow->getId(),"idUtente","EMediaUtente");
                if($propic->getImmagine() == ""){
                    $propic->setImmagine('../../Smarty/img/user.png'); //Default image
                }

                if(isset($toShow)){
                    if ($toShow->isRegistrato()) {
                        $giudizi = $toShow->getListaGiudizi();
                        usort($giudizi, array(EHelper::getInstance(), "sortByDatesGiudizi"));
                        if (sizeof($giudizi) > 10) {
                            array_splice($giudizi, 0, 10);
                        }
                    }

                    VUtente::show($toShow, $canModify, $toShow->isAdmin(), $propic, $giudizi);
                } else {
                    VError::error(0,"Utente non trovato.");
                }

            }
        } else {
            CMain::methodNotAllowed();
        }
    }

    public static function modifica() {
        $id = $_GET["id"];

        if(self::isLogged() && CUtente::getUtente()->getId() === $id) {
            $method = $_SERVER["REQUEST_METHOD"];

            $utente = self::getUtente();

            if ($method == "GET") {
                header("Location: Utente/show/?id=" . $utente->getId());
            } elseif ($method == "POST") {
                if(password_verify($_POST["password"], self::getUtente()->getPassword())) {
                    try {
                        if (isset($_POST["nome"])) {
                            $utente->setNome($_POST["nome"]);
                            FUtente::update($utente->getId(), "id", $utente->getNome(), "nome");
                        }

                        if (isset($_POST["cognome"])) {
                            $utente->setCognome($_POST["cognome"]);
                            FUtente::update($utente->getId(), "id", $utente->getCognome(), "cognome");
                        }

                        if (isset($_POST["username"])) {
                            $utente->setUsername($_POST["username"]);
                            FUtente::update($utente->getId(), "id", $utente->getUsername(), "username");
                        }

                        if (isset($_POST["email"])) {
                            $utente->setEmail($_POST["email"]);
                            FUtente::update($utente->getId(), "id", $utente->getEmail(), "email");
                        }

                        if (isset($_POST["password"])) {
                            try{
                                $utente->setPassword($_POST["password"]);
                            }catch (Exception $e) {
                                VError::error(7);
                                return;
                            }
                            $utente->setPassword(EHelper::getInstance()->hash($_POST["password"]));
                            FUtente::update($utente->getId(), "id", $utente->getPassword(), "password");
                        }

                        if (isset($_POST["propic"])) {
                            if(EInputChecker::getInstance()->isImage($_FILES[2])){
                                $propic = $_FILES;
                                FMedia::update($utente->getId(), "id", $propic, "immagine");
                            }else{
                                VError::error(10);
                            }

                        }
                    } catch (Exception $e) {
                        //TODO: modifica con errore
                    }
                } else {
                    //TODO: modifica con errore di password errata
                }
            }
        } else {
            VError::error(9);
        }
    }

    private static function saveSession(EUtente $utente) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        session_set_cookie_params(time() + 3600, "/", null, false, true); //http only cookie, add session.cookie_httponly=On on php.ini | Andrebbe inoltre inseirto il 4° parametro
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

    public static function isLogged(bool $logout = true): bool {
        if (isset($_COOKIE["PHPSESSID"])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if(isset($_SESSION["utente"])) {
                return true;
            }

            if ($logout) {
                self::logout();
            }
        }

        return false;
    }

    public static function getUtente() {
        if(self::isLogged()) {
            return unserialize($_SESSION["utente"]);
        }

        return NULL;
    }

    public static function bigliettiAcquistati() {
        $utente = self::getUtente();
        if(!isset($utente)) {
            CMain::forbidden();
        }
        if($utente->isAdmin()) {
            header("Location: /");
        }
        $biglietti = $utente->getListaBiglietti();
        usort($biglietti, array(EHelper::getInstance(), "sortByDatesBiglietti"));
        $immagini = [];
        foreach ($biglietti as $item) {
            array_push($immagini,FPersistentManager::getInstance()->load($item->GetProiezione()->getFilm()->getId(), "idFilm", "EMedia"));
        }
        VUtente::showBiglietti($biglietti, $immagini, $utente);
    }

    public static function forgotPassword() {
        if (CUtente::isLogged()) {
            header("Location: /");
        }

        $method = $_SERVER["REQUEST_METHOD"];

        if ($method == "GET") {
            if (isset($_GET["token"])) {
                $token = FPersistentManager::getInstance()->load($_GET["token"], "value", "EToken");
                if(!$token->amIValid()) {
                    FPersistentManager::getInstance()->delete($token->getValue(), "value", "EToken");
                    unset($token);
                }
                if (!isset($token)) {
                    VError::error(0, "Richiedi di inviarti un nuovo link, questo potrebbe essere scaduto.");
                    die;
                }

                VUtente::newPassword($token->getValue());
            } else {
                VUtente::forgotPassword();
            }
        } elseif ($method == "POST") {
            $username = $_POST["username"];

            $utente = null;

            if (EInputChecker::getInstance()->isEmail($username)) {
                $utente = FPersistentManager::getInstance()->load($username, "email", "EUtente");
            } elseif (EInputChecker::getInstance()->isUsername($username)) {
                $utente = FPersistentManager::getInstance()->load($username, "username", "EUtente");
            } else {
                VUtente::forgotPassword($username);
            }

            if (!$utente instanceof EUtente) {
                VUtente::forgotPassword($username);
            } else if (!$utente->isRegistrato()){ //Utente non registrato, crea un nuovo uid come password
                $utente->setPassword(uniqid());
                CMail::sendForgotMailNonRegistrato($utente);
                FPersistentManager::getInstance()->update($utente->getId(), "id", EHelper::getInstance()->hash($utente->getPassword()), "password", "EUtente");
            } else {
                //Crea token
                $uid = uniqid();
                $token = new EToken($uid, new DateTime('now'), $utente);

                if (CMail::sendForgotMail($utente, $token)) { //Invio mail
                    //Reset password
                    //FPersistentManager::getInstance()->update($utente->getId(), "id", "", "password", "EUtente");

                    //Salvataggio token
                    FPersistentManager::getInstance()->save($token);
                } else {
                    VError::error(0, "C'è stato un errore. Riprova più tardi.");
                    die;
                }
            }
                VUtente::forgotPassword(null, true);
        }
    }

    public static function newPassword() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $valueToken = $_POST["token"];
            $token = FPersistentManager::getInstance()->load($_POST["token"], "value", "EToken");

            if(!$token->amIValid()) {
                FPersistentManager::getInstance()->delete($token->getValue(), "value", "EToken");
                unset($token);
            }
            if (!isset($token)) {
                VError::error(0, "Richiedi di inviarti un nuovo link, questo potrebbe essere scaduto.");
                die;
            }

            $password = $_POST["password"];

            //Aggiorna password
            $utente = FUtente::load($token->getUtente()->getId(), "id");
            try {
                $utente->setPassword($password);//Controllo password ok
            } catch (Exception $e) {
                //Password non valida
                VUtente::newPassword($valueToken, true);
                die;
            }
            $hashedPassword = EHelper::getInstance()->hash($password);
            FUtente::update($utente->getId(), "id", $hashedPassword, "password");

            //Consuma token
            FPersistentManager::getInstance()->delete($token->getValue(), "value", "EToken");

            VUtente::loginForm();
        } else {
            CMain::notFound();
        }
    }

    public static function showCommenti() {
        if(self::isLogged()){
            if(!self::getUtente()->isAdmin()){
                $utente = self::getUtente();
                $giudizi = $utente->getListaGiudizi();
                usort($giudizi, array(EHelper::getInstance(), "sortByDatesGiudizi"));
                $propic = FPersistentManager::getInstance()->load($utente->getId(),"idUtente","EMediaUtente");
                if($propic->getImmagine() == ""){
                    $propic->setImmagine('../../Smarty/img/user.png');
                }
                VUtente::showCommenti($giudizi, $utente, $propic);
            }
        } else {
            CMain::forbidden();
        }
    }

    public static function controlloBigliettiNonRegistrato() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if(!CUtente::isLogged()){
                VUtente::showCheckNonRegsitrato(true);
            } else {
                VError::error(0, "Area riservata agli utenti <b>non registrati</b> presso il nostro portale");
                die;
            }
        } else {
            CMain::methodNotAllowed();
        }
    }

}