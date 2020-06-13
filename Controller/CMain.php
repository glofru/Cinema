<?php

/**
 * La classe Main o FrontController dispone di metodi necessari alla corretta gestione di tutte le richieste effettuate sul nsotro sito. Ad ogni richiesta di una pagina viene interpellato al fine di ottenere il risultato atteso.
 * Class CMain
 */
class CMain
{

    /**
     *
     */
    public static function unauthorised() {
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

    public static function notFound() {
        header("HTTP/1.1 404 Not Found");
        header("Location: /404.html");
        die;
    }

    public static function methodNotAllowed() {
        header("HTTP/1.1 405 Method Not Allowed");
        header("Location: /405.html");
        die;
    }

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
                        //CMain::notFound();
                        echo $e->getMessage();
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