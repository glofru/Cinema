<?php

/**
 * La classe Utente mette a disposizione tutti i metodi necessari a permettere ad un utente di poter loggare, eseguire il logout,
 * creare un visitatore quando un utilizzatore si connette al nostro sito, visualizzare e modificare il proprio profilo,
 * gestire i commenti espressi e poter visualizzare i biglietti acquistati.
 * Class CUtente
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Controller
 */
class CUtente
{
    /**
     * Funzione, accessibile sia in GET sia in POST, che esegue le seguenti funzioni:
     *
     * GET) Se richiesta via GET la pagina mostra il form di login. Se l'utente ha in un login precedente cliccato sul bottone 'ricordami' il nome utente o email usata pr il login
     * viene ripreso dal cookie settato ed inserito nella pagina.
     *
     * POST) Se la pagina è richista via metodo POST questa prende i parametri passati e per prima cosa controlla se l'utente ha chiesto di ricodare il proprio username o la propia mail.
     * Allora salva il contenuto in un cookie. Successivamente richiama la funzione chekLogin per sapere se il login è valido o meno.
     */
    public static function login() {
        if (self::isLogged()) {
            header("Location: /MagicBoulevardCinema");
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
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione che permette ad un utente non Registrato di effettuare il login presso il nostro sito e poter accedere alla pagina con i biglietti acquistati. Disponibile solo via metodo POST.
     * La funzione controlla che l'utente non sia già loggato e prende i parametri di email e la password che gli sono stati passati.
     * Se l'utente è registrato viene mostrata una schermata di errore in quanto non destinata a quella tipologia di utenti.
     * Se le credenziali sono giuste l'utente viene portato alla schermata di riepilogo con i propri acquisti.
     * Intenzionalmente non è presente una sessione in questo 'login' in quanto abbiamo voluto rendere il non registrato meno possibile simile all'utente Registrato.
     * Questo implica ad esempio che ogni volta che un utente non Registrato voglia controllare i porprio biglietti dovrà sempre reinserire le credenziali.
     * Va comunque considerato che un non registrato normalemnte non dovrebbe accedere spesso a questa pagina.
     * Lo scopo principale è di questa scelta è comunque quello di spingere i non registrati a registrarsi a tutti gli effetti al nostro sito.
     *
     */
    public static function loginNonRegistrato() {
        if(self::isLogged()){
            header("Location: /MagicBoulevardCinema");
        } else if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if(EInputChecker::getInstance()->isEmail($_POST["email"])) {

                $email = $_POST["email"];
                $password = $_POST["password"];

                $utente = FPersistentManager::getInstance()->login($email, $password, true);
                if (!isset($utente)) {
                    VUtente::showCheckNonRegsitrato(CUtente::getUtente(), true, $email);
                } else if ($utente->isRegistrato()) {
                    VError::error(0, "Pagina destinata ad utenti non Registrati");
                } else {
                    foreach (FPersistentManager::getInstance()->load($utente->getId(), "idUtente", "EBiglietto") as $b) {
                        $utente->addBiglietto($b);
                    }

                    $biglietti = $utente->getListaBiglietti();

                    usort($biglietti, array(EBiglietto::class, "sortByDatesBiglietti"));
                    $immagini = [];

                    foreach ($biglietti as $item) {
                        array_push($immagini, FPersistentManager::getInstance()->load($item->GetProiezione()->getFilm()->getId(), "idFilm", "EMedia"));
                    }

                    VUtente::showCheckNonRegsitrato(CUtente::getUtente(), false, $email, $biglietti, $immagini);
                }
            } else {
                VUtente::showCheckNonRegsitrato(CUtente::getUtente(), true);
            }
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione, privata, che permette di creare una sessione associata ad un utente visistatore. Il cookie di sessione viene inizializzato solo se non è già presente una variabile di sessione
     * associata ad una delle altre tipologie di utente oppure se già non è identificato come visitataore.
     * Viene inoltre modificata localmente la variabile 'session.cookie_httponly' pee evitare che i cookie possano essere fuori dell'HTTP.
     */
    private static function createVisitor() {
        ini_set('session.cookie_httponly', true);
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if(!isset($_SESSION["utente"]) && !isset($_SESSION["nonRegistrato"]) && !isset($_SESSION["visitatore"])){
            session_set_cookie_params(time() + 3600, "/", null, false, true);
            $_SESSION["visitatore"] = serialize(new EVisitatore());
        }
    }

    /**
     * Funzione che esegue il logut dell'utente. Se è impostata a true la variabile redierct si viene riportati alla home page al termine dell.operazione.
     * La funzione svolge le operazioni relative all'eliminazione delle variabili di sessione in RAM e sul FS del nostro server. Al termne viene eliminato il cookie di sessione.
     * Una volta distrutta la sessione si crea una nuova sessione ma con un utente visitatore.
     * @param bool $redirect, indica se bisogna essere reindirizzati alla home page dopo il logout.
     */
    public static function logout($redirect = true) {
        if($_SERVER["REQUEST_METHOD"] === "GET") {


            if (isset($_COOKIE["PHPSESSID"])) {
                session_start();
                session_unset();
                session_destroy();
                setcookie("PHPSESSID", "", time() - 3600, "/");
                self::createVisitor();
            }
            if ($redirect) {
                header("Location: /MagicBoulevardCinema");
            }
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione privata sfruttata per controllare se le credenziali inserite dall'utente corrispondano ad un utente realmente presente nel nostro DB.
     * Per prima cosa si controlla se sia stata passato un username od una email valida. Sennò si ritorna alla schermata di login.
     * Di seguito si tenta il login dell'utente sul DB. Se ha successo si controlla se l'utente sia bannato, in tal caso si viene portati su una schermata di errore.
     * Se l'utente non è un admin vengono caricati i suoi biglietti ed i suoi giudizi.
     * Al termine si procede ad invocare la funzione di saveSession per salvare l'utente nella sessione.
     * @param $user, username o email forniti in fase di login.
     * @param $password, password fornita in fase di login.
     */
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
                    $giudizi = $pm->load($utente->getId(), "idUtente", "EGiudizio");
                    foreach ($giudizi as $g){
                        $utente->addGiudizio($g);
                    }
                }
                self::saveSession($utente);
                header("Location: /MagicBoulevardCinema");
            }
        } else {
            VUtente::loginForm($user, true);
        }
    }

    /**
     * Funzione che permette di mostrare il profilo di un utente. Richiamabile solo via metodo GET.
     * Viene passato come parametro l'id dell'utente cercato che se non esiste conduce ad una pagina di errore.
     * Altrimenti si procede a caricare tutti i dati dell'utente dal DB, se il profilo non appartiene direttamente all'utente stesso.
     * In questo caso i parametri vengono presi dalla variabile di sessione dell'utente e si abilita la variabile canModify così da permettere all'utente di modificare il proprio profilo.
     * Se l'utente vuole vedere il proprio profilo e non è un admin vengono reperite inoltre le informazioni sulla sua eventuale iscrizione alla newsletter.
     * Al termine viene visualizzata la schermata con i relativi giudizi espressi se si sta visualizzando un profilo un utente non Admin.
     *
     */
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

    /**
     * Funzione, accessibile sia via GET sia via POST, che permette ad un utente di visualizzare una schermaata contenente i propri e dati e di modificare questi ultimi.
     *
     * GET) Se richiamata via GET mostra una schermata con tutti i dati personali dell'utente.
     *
     * POST) Se richiamata in POST permette di modificare i dati dell'utente con quelli fornuti.
     */
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
                    if (is_uploaded_file($_FILES["propic"])) {
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
                   VUtente::modifica($utente, FPersistentManager::getInstance()->load($utente->getId(),"idUtente","EMediaUtente"), EGenere::getAll(), FPersistentManager::getInstance()->isASub($utente), explode(";", FPersistentManager::getInstance()->load($utente->getId(), "idUtente", "FNewsLetter")));
                }
            } else {
                CMain::unauthorized();
            }
        } elseif ($method === "GET") {
            $id = $_GET["id"];

            if (self::isLogged() && CUtente::getUtente()->getId() == $id) {
                $pm = FPersistentManager::getInstance();
                $utente = CUtente::getUtente();

                $propic = $pm->load($utente->getId(),"idUtente","EMediaUtente");

                VUtente::modifica($utente, $propic, EGenere::getAll(), FPersistentManager::getInstance()->isASub($utente), explode(";", FPersistentManager::getInstance()->load($utente->getId(), "idUtente", "FNewsLetter")));
            } else {
                CMain::unauthorized();
            }
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione che permette dato un utente di salvarlo nella sessione. Viene sovrascritta localmente la variabile 'session.cookie_httponly' per evitare che il cookie di sessione sia disponibile
     * fuori dall'HTTP.
     * Se è impostata una variabile di sessione inerente all'utente non registrato questa viene eliminata.
     * Viene rigenerato il cookie di sessione per fare sì che sia diverso da quello precedente. Norma di sicurezza perchè il cookie da utente visitatore non è direttamente gestibile dall'utente,
     * che invece può gestire quello da Utente eseguendo il logout quando vuole chiudere la sessione.
     * @param EUtente|null $utente, utente da salvare.
     */
    public static function saveSession($utente = null) {
        ini_set('session.cookie_httponly', true);
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

    /**
     * Funzione accessibile sia via GET sia via POST che permette di far registrare un nuovo utente nel nostro Database.
     *
     * GET) Se chiamata via metodo GET la funzione mostra all'utente la schermatta di registrazione.
     *
     *POST) Se chiamata via POST allora vengono presi i parametri inseriti e viene creato un nuovo utente. Viene, quindi, inviata una mail di conferma dell'iscrizione.
     *
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public static function signup() {
        if (self::isLogged()) {
            header("Location: /MagicBoulevardCinema");
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
                header("Location: /MagicBoulevardCinema");
            }
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione che permette di sapere se un utente è attualmente loggato nel nostro sito.
     * @return bool, esito del controllo.
     */
    public static function isLogged(): bool {
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

    /**
     * Funzione che restituisce l'utente salvato in sessione.
     * @return mixed, un utente registrato oppure un utente visitatore.
     */
    public static function getUtente() {
        if(self::isLogged()) {
            return unserialize($_SESSION["utente"]);
        } else {
            self::createVisitor();
            return unserialize($_SESSION["visitatore"]);
        }
    }

    /**
     * Funzione che permette di mostrare tutti i biglietti acquistati dall'utente.
     */
    public static function bigliettiAcquistati() {
        if($_SERVER["REQUEST_METHOD"] === "GET") {
            if (CUtente::isLogged()) {
                $utente = self::getUtente();

                if ($utente->isAdmin()) {
                    header(0, "Pagina non disponibile agli admin.");
                }

                $biglietti = $utente->getListaBiglietti();
                usort($biglietti, array(EBiglietto::class, "sortByDatesBiglietti"));

                $immagini = [];
                foreach ($biglietti as $item) {
                    array_push($immagini, FPersistentManager::getInstance()->load($item->GetProiezione()->getFilm()->getId(), "idFilm", "EMedia"));
                }

                VUtente::showBiglietti($biglietti, $immagini, $utente);
            } else {
                CMain::unauthorized();
            }
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione che permette di accedere alla schermata di reset della password se chiamata via GET.
     * Altrimenti, se chiamata via POST, da il via alla fase di reset della password ed invio sulla mail di un link di reset della password.
     * @throws Exception
     */
    public static function forgotPassword() {
        if (CUtente::isLogged()) {
            header("Location: /MagicBoulevardCinema");
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

    /**
     * Funzione che viene eseguita quando un utente accede alla pagina di ereset della password ed inserisce una nuova password.
     * Se la password ed il token sono validi esegue il cambio della password.
     * Accessibile solo tramite metodo POST.
     * @throws \PHPMailer\PHPMailer\Exception
     */
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
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione che permette di mostrare tutti i giudizi espressi dall'utente. Accessible solo tramite metodo GET.
     */
    public static function showCommenti() {
        if($_SERVER["REQUEST_METHOD"] === "GET") {
            if (self::isLogged()) {
                if (!self::getUtente()->isAdmin()) {
                    $utente = self::getUtente();
                    $giudizi = $utente->getListaGiudizi();
                    usort($giudizi, array(EGiudizio::class, "sortByDatesGiudizi"));
                    $propic = FPersistentManager::getInstance()->load($utente->getId(), "idUtente", "EMediaUtente");
                    VUtente::showCommenti($giudizi, $utente, $propic);
                }
            } else {
                CMain::unauthorized();
            }
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione che permette di visualizzare i biglietti acquistati se l'utente è un utente non Registrato.
     */
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