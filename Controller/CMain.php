<?php

/**
 * La classe Main o FrontController dispone di metodi necessari alla corretta gestione di tutte le richieste effettuate sul nsotro sito. Ad ogni richiesta di una pagina viene interpellato al fine di ottenere il risultato atteso.
 * Class CMain
 */
class CMain
{

    /**
     * Funzione che permette di visualizzare una pagina 401 Unauthorised, con relativa intestazione HTTP, se l'utente tenta di accedere ad una pagina per la quale non è autorizzato.
     */
    public static function unauthorized() {
        header("HTTP/1.1 401 Unauthorized ");
        header("Location: /401.html");
    }
    /**
     * Funzione che mette a disposizione la vsiualizzazione d una pagina 403 forbidden con relativa intestazione HTTP.
     * Da richiamare se l'utente accede ad una pagina riservata ad utilizzo interno dei gestori.
     */
    public static function forbidden() {
        header("HTTP/1.1 403 Forbidden");
        header("Location: /403.html");
        die;
    }

    /**
     * Funzione che richiama una pagina 404 Not Found, con relativa intestazione HTTP, se l'utente cerca una pagina inesistente sul nsotro server.
     */
    public static function notFound() {
        header("HTTP/1.1 404 Not Found");
        header("Location: /404.html");
        die;
    }

    /**
     * Funzione che mostra una pagina 405 Metod Not Allowed, con relativa intestazione HTTP, se l'utente tenta di accedere ad una pagina con un metodo per il quale la pagina non è progettata.
     */
    public static function methodNotAllowed() {
        header("HTTP/1.1 405 Method Not Allowed");
        header("Location: /405.html");
        die;
    }

    /**
     * Funzione principale dell'applicazione che viene invocata ogni volta che viene richiesta una pagina. Svolge le seguenti funzioni:
     *
     * 1) Modifica temporanemanete le variabili, presenti nel PHP.ini, 'session.gc_probability' e 'session.gc_divisor' al fine di aumentare le possibilità di lanciare il GC delle sessioni.
     * Questo è stato fatto in quanto i nostri utenti regsitrati dovrebbero avere nei loro attributi anche informazioni di pagamento. Di conseguenza è meglio fare sì che se l'utente non ha
     * effettuato il logout comunque il sito abbia più probabilità di eliminarne i dati di sessione.
     *
     * 2) Controlla se è stata richiesta la sezione 'api'. In questo caso si interroga il CGestoreREST per ottenere in output oggetti in formato JSON.
     *
     * 3) Se non è stata rihciamata la sezione 'api' controlla se è presente in sessione un utente Non Registrato. Nel sostro sito un oggetto salvato in sessione del tipo utente Non Registrato
     * deve esistere solo se la pagina richiesta è quella di confermaAcquisto. Altrimenti deve essere cancellata la sessione di quell'utente.
     *
     * 4) Se l'utente è un Utente Registrato loggato viene controllato se la password presente in sessione è la stessa presente sul DB. Questo per fare sì che se la password viene modificata
     * allora l'utente attualmente registrato venga eliminato dalla sessione e costretto l'utente a rieseguire il login. Utile nel caso di appropriazione dell'account da parte di un'entità malevola.
     * L'utente può resettare la password e 'cacciare' chi abbia preso l'account. Oppure se vittima di ciò può contattarci per risolvere la questione.
     *
     * 5) Se l'uetnte è un utente registrato loggato allora viene controllato se non sia stato bannato. Questo per fare sì che un ban di un amministratore abbia effetto non appena l'utente
     * cerchi di acricare una pagina diversa da quella in cui è. In questo modo una volta bannato un utente non può più eseguire nessuna azione. Se bannato viene quind eliminato dalla sessione.
     *
     * 6) Se non è presente un cookie con le preferenze ne viene istanziato uno nuovo. Durata del cookie 30 giorni. non contiene dati particolarmente sensibili quindi può essere tenuto per un ungo periodo di tempo.
     *
     * 7) Viene, quindi, parsato l'URL e se viene richiesta la classe Utility allora si dà errore 403 forbidden.
     * Lo stesso errore viene fornito se si tenta di accedere ad un metodo privato di una qualsiasi classe Controller.
     *
     * 8) Infine se esiste una classe controller con il relativo metodo questa viene chiamata. Altrimenti viene generata una schermata di errore
     *
     *
     *
     * @param string $url, url richiesto dall'utente.
     */
    public static function run(string $url)
    {
        ini_set('session.gc_probability', 10);
        ini_set('session.gc_divisor', 200);
        $parsed_url = parse_url($url);
        $path = $parsed_url["path"];
        $isApi = strstr($path, "/api/");
        if ($isApi === false) {
            //GESTIONE UTENTE NON REGISTRATO
            $pass = !CUtente::isLogged(false) && isset($_SESSION["nonRegistrato"]) && $path == "/Acquisto/confermaAcquisto";

            if(!$pass && isset($_SESSION["nonRegistrato"])){
                CUtente::logout(false);

            } else if (!$pass && CUtente::isLogged()) {
                //Check ban dal database
                $check = FPersistentManager::getInstance()->load(CUtente::getUtente()->getId(), "id", "EUtente");
                if ($check->isBanned()) {
                    CUtente::logout(false);
                    VError::error(4);
                } else if (CUtente::getUtente()->getPassword() !== $check->getPassword()){
                    CUtente::logout(false);
                    VError::error(0, "La password è stata cambiata!");
                }
            } else if(!CUtente::isLogged()) {
                CUtente::getUtente();
            }


            if(!isset($_COOKIE["preferences"])){
                setcookie("preferences", CUtente::getUtente()->preferences(null), 86400 * 30, '/');
            }

            if ($path == "/" || $path == "/index.php") {
                CHome::showHome();
            } else {
                $res = explode("/", $path);

                array_shift($res);

                $controller = "C" . $res[0];

                try {
                    $class = new ReflectionClass($controller);
                } catch (ReflectionException $e) {
                    CMain::notFound();
                }

                if($class->getName() === "CUtility"){
                    CMain::forbidden();
                }


                $function = $res[1];

                try {
                    $reflection = $class->getMethod($function);
                        
                    if(!$reflection->isPublic()){
                        CMain::forbidden();
                    }

                    try {
                        $controller::$function();
                    } catch (Throwable $e) {
                        CMain::notFound();
                    }

                } catch (ReflectionException $e) {
                   self::notFound();
                }
            }
        } else {
            $api = explode("/", $path);
            array_shift($api);
            array_shift($api);
            if ($api[0] !== "GestoreREST") {
                self::notFound();
            } else {
                $function = $api[1];
                if (method_exists("CGestoreREST", $function)) {
                    $function = $api[1];
                    $controller = "CGestoreREST";
                    $controller::$function();
                } else {
                    self::notFound();
                }

            }
        }
    }
}