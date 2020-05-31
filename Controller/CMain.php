<?php

class CMain
{
    private static function notFound() {
        header("HTTP/1.1 404 Not Found");
        header("Location: /404.html");
    }

    public static function run(string $url)
    {
        $utente = CUtente::getUtente();
        if(isset($utente)) {
            $check = FPersistentManager::getInstance()->load($utente->getId(),"id","EUtente");
            if($check->isBanned()){
                VError::error(4);
                CUtente::logout();
                die;
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

            if (in_array($controller . ".php", $controllers) && $res[1] != null) {
                $function = $res[1];
                $controller::$function();
            } else {
                self::notFound();
            }
        }
    }
}