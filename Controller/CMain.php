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
            if ($path == "/")
            {
                $vhome = new VHome();
                $vhome->home();
            }
        }
    }
}