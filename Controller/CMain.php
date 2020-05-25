<?php

class CMain
{
    public function __construct() {}

    public function run(string $url)
    {
        $parsed_url = parse_url($url);
        $path = $parsed_url["path"];
        $method = $_SERVER["REQUEST_METHOD"];

        if ($method == "GET")
        {
            if ($path == "/" || $path == "/index.php")
            {
                CHome::showHome();
            }
            else
            {
                $res = explode("/", $path);
                array_shift($res);
                $controller = "C" . $res[0];
                $controllers = scandir("Controller");
                if (in_array($controller . ".php", $controllers))
                {
                    if (array_key_exists(1, $res))
                    {
                        $function = $res[1];

                        $controller::$function();
                    }
                    else
                    {
                        print "boh";
//                        $controller::loadView();
                    }
                }
                else
                {
                    header("Location: /404.html");
                }
            }
        }
        elseif ($method == "POST")
        {
            //TODO: qui avviene la stessa cosa di GET perché porco negro
            if ($path == "/" || $path == "/index.php")
            {
                CHome::showHome();
            }
            else
            {
                $res = explode("/", $path);
                array_shift($res);
                $controller = "C" . $res[0];
                $controllers = scandir("Controller");
                if (in_array($controller . ".php", $controllers))
                {
                    if (array_key_exists(1, $res))
                    {
                        $function = $res[1];

                        $controller::$function();
                    }
                    else
                    {
                        print "boh";
//                        $controller::loadView();
                    }
                }
                else
                {
                    header("Location: /404.html");
                }
            }
        }
    }
}