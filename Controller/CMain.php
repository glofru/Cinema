<?php

class CMain
{
    public static function notFound() {
        header("HTTP/1.1 404 Not Found");
        header("Location: /404.html");
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
                }
            }

            if ($path == "/" || $path == "/index.php") {
                CHome::showHome();
            } else {
                $res = explode("/", $path);

                array_shift($res);
                $controller = "C" . $res[0];
                $controllers = scandir("Controller");

                $function = $res[1];

                if (in_array($controller . ".php", $controllers) && method_exists($controller, $function)) {
                    $function = $res[1];

                    $controller::$function();
                } else {
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