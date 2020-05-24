<?php


class CAdmin
{

    public static function addFilm()
    {
        $method = $_SERVER["REQUEST_METHOD"];

        if ($method == "GET")
        {
            $vAdmin = new VAdmin();
            $vAdmin->addFilm();
        }
        elseif ($method == "POST")
        {
            print_r($_POST);
        }
    }

}