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
    
    static function logout($redirect = true) {
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
        } else {
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
                    $giudizi = $pm->load($_GET["idShow"], "idUtente", "EGiudizio");
                    usort($giudizi, array(EHelper::getInstance(), "sortByDatesGiudizi"));
                    if(sizeof($giudizi) > 10){
                        array_splice($giudizi, 0, 10);
                    }
                    VUtente::showUtente($toShow, $canModify, $toShow->isAdmin(), $propic, $giudizi);
                }
                else {
                    VError::error(0,"PROFILO UTENTE NON TROVATO!");
                }

            }
        }
    }



    public static function insertPassword(): bool {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_GET["username"];
            $password = $_POST["password"];
            self::checkLogin($username, $password);
            return true;
        }else
            return false;
    }

    public static function verificaUtente(): bool {
        if($_SERVER['REQUEST_METHOD'] == "GET" && self::isLogged()) {
            $utente = self::getUtente();
            if (!isset($_GET["idShow"])) {
                // header("Location: /");
                echo "NOTSET";
            } else {
                    if (isset($utente) && $utente->getId() === intval($_GET["idShow"]))
                        return true;
                    else
                        return false;
            }
        }
    }



    private static function modificaUtente()
    {
        if(self::verificaUtente() == true);{
            $method = $_SERVER["REQUEST_METHOD"];
            if ($method == "GET") {
               return self::showUtente();
            } elseif ($method == "POST") {
                $pm = FPersistentManager::getInstance();
                if(self::insertPassword() == true){
                    $oldpassword = $_GET["password"];
                    //NOME
                    if($_POST["nome"] != $_GET["nome"] || $_POST["nome"] != null){
                        $input = $_POST["nome"];
                        if(EInputChecker::getInstance()->isNome($input) == true ){
                            $pm->update($_GET["nome"], "nome", $input, "nome", "EUtente" );
                            $status = "OPERAZIONE RIUSCITA";
                        }else{
                            $status = "ERRORE: NOME NON VALIDO";
                        }
                    //COGNOME
                    }elseif ($_POST["cognome"] != $_GET["cognome"] || $_POST["cognome"] != null){
                        $input = $_POST["cognome"];
                        if(EInputChecker::getInstance()->isNome($input) == true ){
                            $pm->update($_GET["cognome"], "cognome", $input, "cognome", "EUtente" );
                            $status = "OPERAZIONE RIUSCITA";
                        }else{
                            $status = "ERRORE: COGNOME NON VALIDO";
                        }
                    }elseif ($_POST["username"] != $_GET["username"] || $_POST["username"] != null){
                        $input = $_POST["username"];
                        if(EInputChecker::getInstance()->isUsername($input) == true ){
                            $pm->update($_GET["username"], "username", $input, "username", "EUtente" );
                            $status = "OPERAZIONE RIUSCITA";
                        }else{
                            $status = "ERRORE: USERNAME NON VALIDA";
                        }
                    }elseif ($_POST["email"] != $_GET["email"] || $_POST["email"] != null) {
                        $input = $_POST["email"];
                        if (EInputChecker::getInstance()->isUsername($input) == true) {
                            $pm->update($_GET["email"], "email", $input, "email", "EUtente");
                            $status = "OPERAZIONE RIUSCITA";
                        } else {
                            $status = "ERRORE: EMAIL NON VALIDA";
                        }
                    }elseif ($_POST["propic"] != $_GET["propic"] || $_POST["propic"] != null) {
                        $input = $_POST["propic"];
                        if (EInputChecker::getInstance()->isImage($input) == true) {
                            $pm->update($_GET["propic"], "immagine", $input, "immagine", "EMediaUtente");
                            $status = "OPERAZIONE RIUSCITA";
                        } else {
                            $status = "ERRORE: IMMAGINE NON VALIDA";
                        }
                    }elseif ($_POST["password"] != $_GET["password"] || $_POST["password"] != null) {
                        $input = $_POST["password"];
                        if (EInputChecker::getInstance()->validatePassword($_POST["password"],$input) == true && $input !== $oldpassword) {
                            $pm->update($_GET["password"], "password", $input, "password", "EUtente");
                            $status = "OPERAZIONE RIUSCITA";
                        } else {
                            $status = "ERRORE: PASSWORD NON VALIDA";
                        }
                    }
                } return $status;

            }
            header("Location/");
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
                $utente = new EUtente($nome, $cognome, $username, $email, $password, false);
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
        if (isset($_COOKIE["PHPSESSID"])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if(isset($_SESSION["utente"])) {
                return true;
            }
            else {
                CUtente::logout();
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getUtente() {
        if(self::isLogged()) {

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
            }

            //Crea token
            $uid = uniqid();
            $token = new EToken($uid, new DateTime('now'), $utente);

            if (CMail::sendForgotMail($utente, $token)) { //Invio mail
                //Reset password
                FPersistentManager::getInstance()->update($utente->getId(), "id", "", "password", "EUtente");

                //Salvataggio token
                FPersistentManager::getInstance()->save($token);
            } else {
                VError::error(0, "C'è stato un errore. Riprova più tardi.");
                die;
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
                $giudizi = FPersistentManager::getInstance()->load($utente->getId(), "idUtente", "EGiudizio");
                usort($giudizi, array(EHelper::getInstance(), "sortByDatesGiudizi"));
                $propic = FPersistentManager::getInstance()->load($utente->getId(),"idUtente","EMediaUtente");
                if($propic->getImmagine() == ""){
                    $propic->setImmagine('../../Smarty/img/user.png');
                }
                VUtente::showCommenti($giudizi, $utente, $propic);
            }
        }
        header("Location: /");
    }

}