<?php

class CMain
{
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
        $parsed_url = parse_url($url);
        $path = $parsed_url["path"];
        $isApi = strstr($path, "/api/");
        if ($isApi === false) {
            $pass = !CUtente::isLogged(false) && isset($_SESSION["nonRegistrato"]) && $path == "/Acquisto/confermaAcquisto";

            if (!$pass && CUtente::isLogged()) {
                //Check ban dal database
                $check = FPersistentManager::getInstance()->load(CUtente::getUtente()->getId(), "id", "EUtente");
                if ($check->isBanned()) {
                    CUtente::logout(false);
                    VError::error(4);
                } else if (CUtente::getUtente()->getPassword() !== $check->getPassword()){
                    CUtente::logout(false);
                    VError::error(0, "La password è stata cambiata!");
                }
            }

            if ($path == "/" || $path == "/index.php") {
                CHome::showHome();
            } else {
                $res = explode("/", $path);

                array_shift($res);

                $controller = "C" . $res[0];
                $function = $res[1];
                try {
                    $class = new ReflectionClass($controller);
                }
                catch (ReflectionException $e) {
                    CMain::notFound();
                }

                $function = $res[1];

                try {
                    $reflection = $class->getMethod($function);
                        
                    if(!$reflection->isPublic()){
                        self::methodNotAllowed();
                    }

                    $controller::$function();

                } catch (ReflectionException $e) {
                    CMain::methodNotAllowed();
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