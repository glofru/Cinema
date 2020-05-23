<?php


class Installator
{
    static function checkInstall(): bool
    {
        if(isset($_COOKIE["installed"]))
        {
            return true;
        }

        setcookie("installed", true);
        return false;
    }

    static function install()
    {
        
    }
}