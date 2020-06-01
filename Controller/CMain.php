<?php

class CMain
{
    public static function notFound() {
        header("HTTP/1.1 404 Not Found");
        header("Location: /404.html");
    }

    public static function run(string $url) {
        if (CUtente::isLogged()) {
            //Check ban dal database
            $check = FPersistentManager::getInstance()->load(CUtente::getUtente()->getId(),"id","EUtente");
            if($check->isBanned()){
                CUtente::logout(false);
                VError::error(4);
            }
        }

        $parsed_url = parse_url($url);
        $path = $parsed_url["path"];

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
    }
}