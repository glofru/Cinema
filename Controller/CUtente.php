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
                VUtente::showCheckNonRegsitrato(CUtente::getUtente(), true, $email);
            } else if($utente->isRegistrato()) {
                VError::error(0, "Pagina destinata ad utenti non Registrati");
            } else {
                foreach (FPersistentManager::getInstance()->load($utente->getId(), "idUtente", "EBiglietto") as $b) {
                    $utente->addBiglietto($b);
                }

                $biglietti = $utente->getListaBiglietti();

                usort($biglietti, array(EBiglietto::class, "sortByDatesBiglietti"));
                $immagini = [];

                foreach ($biglietti as $item) {
                    array_push($immagini,FPersistentManager::getInstance()->load($item->GetProiezione()->getFilm()->getId(), "idFilm", "EMedia"));
                }

                VUtente::showCheckNonRegsitrato(CUtente::getUtente(), false, $email, $biglietti, $immagini);
            }
        } else {
            CMain::methodNotAllowed();
        }
    }

    public static function createVisitor() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if(!isset($_SESSION["utente"]) && !isset($_SESSION["nonRegistrato"]) && !isset($_SESSION["visitatore"])){
            session_set_cookie_params(time() + 3600, "/", null, false, true);
            $_SESSION["visitatore"] = serialize(new EVisitatore());
        }
    }
    
    public static function logout($redirect = true) {
        if(isset($_COOKIE["PHPSESSID"])) {
            session_start();
            session_unset();
            session_destroy();
            setcookie("PHPSESSID", "", time() - 3600,"/");
            self::createVisitor();
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
                if(!$utente->isAdmin()) {
                    $biglietti = $pm->load($utente->getId(), "idUtente", "EBiglietto");
                    foreach ($biglietti as $b) {
                        $utente->addBiglietto($b);
                    }
                }
                self::saveSession($utente);
                header("Location: /");
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
                    $isASub = FPersistentManager::getInstance()->isASub(CUtente::getUtente());
                    $prefs = str_replace(";",", ", FPersistentManager::getInstance()->load(CUtente::getUtente()->getId(), "idUtente", "ENewsLetter"));
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

                if(isset($toShow)){
                    if ($toShow->isRegistrato()) {
                        $giudizi = $toShow->getListaGiudizi();
                        usort($giudizi, array(EGiudizio::class, "sortByDatesGiudizi"));
                        if (sizeof($giudizi) > 10) {
                            array_splice($giudizi, 0, 10);
                        }
                    }

                    VUtente::show($toShow, $canModify, $propic, $giudizi, $isASub, $prefs);
                } else {
                    VError::error(0,"Utente non trovato.");
                }

            }
        } else {
            CMain::methodNotAllowed();
        }
    }

    public static function modifica() {
        $method = $_SERVER["REQUEST_METHOD"];

        if ($method === "POST") {
            $id = $_POST["utente"];

            if (self::isLogged() && CUtente::getUtente()->getId() == $id) {
                $utente = self::getUtente();
                $pm = FPersistentManager::getInstance();

                try {
                    if (isset($_POST["nome"])) {
                        $utente->setNome($_POST["nome"]);
                        $pm->update($utente->getId(), "id", $utente->getNome(), "nome", "EUtente");
                    }

                    if (isset($_POST["cognome"])) {
                        $utente->setCognome($_POST["cognome"]);
                        $pm->update($utente->getId(), "id", $utente->getCognome(), "cognome", "EUtente");
                    }

                    if (isset($_POST["username"])) {
                        $utente->setUsername($_POST["username"]);
                        $pm->update($utente->getId(), "id", $utente->getUsername(), "username", "EUtente");
                    }

                    if (isset($_POST["email"])) {
                        $utente->setEmail($_POST["email"]);
                        $pm->update($utente->getId(), "id", $utente->getEmail(), "email", "EUtente");
                    }

                    if (isset($_POST["vecchiaPassword"]) && $_POST["vecchiaPassword"] != "") {
                        if (password_verify($_POST["vecchiaPassword"], $utente->getPassword())) {
                            $utente->setPassword($_POST["nuovaPassword"]); //Check password

                            $pm->updatePasswordUser($utente);
                        } else {
                            throw new Exception("Vecchia password errata");
                        }
                    }
                    if (isset($_FILES["propic"])) {
                        if (EInputChecker::getInstance()->isImage($_FILES["propic"]["type"]) && EInputChecker::getInstance()->isLight($_FILES["propic"]["size"])) {
                            $propic = $_FILES["propic"];
                            $name = $propic["name"];
                            $mimeType = $propic["type"];
                            $propic = file_get_contents($propic["tmp_name"]);
                            $propic = base64_encode($propic);
                            $data = new DateTime('now');
                            $data = $data->format('Y-m-d');
                            FPersistentManager::getInstance()->update($utente->getId(), "idUtente", $propic, "immagine", "EMediaUtente");
                            FPersistentManager::getInstance()->update($utente->getId(), "idUtente", $data, "date", "EMediaUtente");
                            FPersistentManager::getInstance()->update($utente->getId(), "idUtente", $name, "fileName", "EMediaUtente");
                            FPersistentManager::getInstance()->update($utente->getId(), "idUtente", $mimeType, "mimeType", "EMediaUtente");
                        } else {
                            VError::error(10);
                        }

                    }

                    if(isset($_POST["newsletter"])){
                        $prefs = "";
                        foreach (EGenere::getAll() as $genere){
                            if(isset($_POST[$genere])){
                                $prefs .= $genere . ";";
                            }
                        }
                        $prefs = substr($prefs,0,-1);
                        if(FPersistentManager::getInstance()->isASub($utente)){
                            FPersistentManager::getInstance()->update($utente->getId(), "idUtente", $prefs, "preferenze", "ENewsLetter");
                        } else {
                            FPersistentManager::getInstance()->saveNS($utente, $prefs);
                        }
                    } else {
                        if(FPersistentManager::getInstance()->isASub($utente)){
                            FPersistentManager::getInstance()->delete($utente->getId(), "idUtente", "ENewsLetter");
                        }
                    }

                    self::saveSession($utente);
                   header("Location: /Utente/show/?id=" . $utente->getId());
                } catch (Exception $e) {
                    print $e->getMessage();
//                    VUtente::modifica($utente);
                }
            } else {
                CMain::forbidden();
            }
        } elseif ($method === "GET") {
            $id = $_GET["id"];

            if (self::isLogged() && CUtente::getUtente()->getId() == $id) {
                $pm = FPersistentManager::getInstance();
                $utente = CUtente::getUtente();

                $propic = $pm->load($utente->getId(),"idUtente","EMediaUtente");

                VUtente::modifica($utente, $propic, EGenere::getAll(), FPersistentManager::getInstance()->isASub($utente), explode(";", FPersistentManager::getInstance()->load($utente->getId(), "idUtente", "FNewsLetter")));
            } else {
                CMain::forbidden();
            }
        }
    }

    public static function saveSession($utente = null) {
        if(!isset($utente)) {
            VError::error(100);
            die;
        }
        if(isset($_SESSION["visitatore"])){
            unset($_SESSION["visitatore"]);
        }
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        session_set_cookie_params(time() + 3600, "/", null, false, true); //http only cookie, add session.cookie_httponly=On on php.ini | Andrebbe inoltre inserito il 4° parametro
        // a TRUE per fare si che il cookie viaggi solo su HTTPS. E' FALSE perchè non abbiamo un certificato SSL ma in un contesto reale va messo a TRUE!!!
        $salvare = serialize($utente);
        $_SESSION['utente'] = $salvare;
    }

    public static function signup() {
        if (self::isLogged()) {
            header("Location: /");
        } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
            VUtente::signup(EGenere::getAll());
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST["nome"];
            $cognome = $_POST["cognome"];
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            try {
                $utente = new ERegistrato($nome, $cognome, $username, $email, $password, false);
            } catch (Exception $e) {
                VUtente::signup(EGenere::getAll(), $nome, $cognome, $username, $email, $e->getMessage());
                return;
            }

            $pm = FPersistentManager::getInstance();

            if (FUtente::exists($utente, true)) { //Se la mail già esiste
                VUtente::signup(EGenere::getAll(), $nome, $cognome, $username, $email, null, true);
            } elseif (FUtente::exists($utente, false)) { //Se l'username già esiste
                VUtente::signup(EGenere::getAll(), $nome, $cognome, $username, $email, null, false);
            } else {
                if(!is_uploaded_file($_FILES["propic"])){
                    $name = "";
                    $mimeType = "";
                    $data = "";
                } else if(EInputChecker::getInstance()->isImage($_FILES["propic"]["type"]) && EInputChecker::getInstance()->isLight($_FILES["propic"]["size"])) {
                    $img = $_FILES["propic"];

                    $name = $img["name"];
                    $mimeType = $img["type"];

                    $data = file_get_contents($img["tmp_name"]);
                    $data = base64_encode($data);
                } else {
                    VUtente::signup(EGenere::getAll(), $nome, $cognome, $username, $email, "Immagine non valida! Riprovare.");
                    die;
                }

                $time = new DateTime("now");

                $pm->signup($utente);

                $propic = new EMediaUtente($name, $mimeType, $time, $data, $utente);
                FPersistentManager::getInstance()->save($propic);

                if(isset($_POST["newsletter"])){
                    $ns = "";
                    $generi = EGenere::getAll();
                    foreach ($generi as $item) {
                        if(isset($_POST[$item])){
                            $ns .= $item.";";
                        }
                    }
                    $ns = substr($ns, 0, -1);
                    FPersistentManager::getInstance()->saveNS($utente,$ns);
                }
                self::saveSession($utente);
                CMail::newEntry($utente);
                header("Location: /");
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
        }

        return false;
    }

    public static function getUtente() {
        if(self::isLogged()) {
            return unserialize($_SESSION["utente"]);
        } else {
            self::createVisitor();
            return unserialize($_SESSION["visitatore"]);
        }
    }

    public static function bigliettiAcquistati() {
        if(CUtente::isLogged()) {
            $utente = self::getUtente();

            if($utente->isAdmin()) {
                header(0, "Pagina non disponibile agli admin.");
            }

            $biglietti = $utente->getListaBiglietti();
            usort($biglietti, array(EBiglietto::class, "sortByDatesBiglietti"));

            $immagini = [];
            foreach ($biglietti as $item) {
                array_push($immagini,FPersistentManager::getInstance()->load($item->GetProiezione()->getFilm()->getId(), "idFilm", "EMedia"));
            }

            VUtente::showBiglietti($biglietti, $immagini, $utente);
        } else {
            CMain::forbidden();
        }
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
                FPersistentManager::getInstance()->updatePasswordUser($utente);
                CMail::sendForgotMailNonRegistrato($utente);
            } else {
                //Crea token
                $uid = uniqid();
                $token = new EToken($uid, new DateTime('now'), $utente);

                if (CMail::sendForgotMail($utente, $token)) { //Invio mail
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

            FPersistentManager::getInstance()->updatePasswordUser($utente);

            //Consuma token
            FPersistentManager::getInstance()->delete($token->getValue(), "value", "EToken");
            CMail::modifiedPassword($utente);
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
                usort($giudizi, array(EGiudizio::class, "sortByDatesGiudizi"));
                $propic = FPersistentManager::getInstance()->load($utente->getId(),"idUtente","EMediaUtente");
                VUtente::showCommenti($giudizi, $utente, $propic);
            }
        } else {
            CMain::forbidden();
        }
    }

    public static function controlloBigliettiNonRegistrato() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if(!CUtente::isLogged()){
                VUtente::showCheckNonRegsitrato(CUtente::getUtente(),true);
            } else {
                VError::error(0, "Area riservata agli utenti <b>non registrati</b> presso il nostro portale");
                die;
            }
        } else {
            CMain::methodNotAllowed();
        }
    }

}