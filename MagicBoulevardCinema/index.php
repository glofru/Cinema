<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
require_once 'Utility/autoload.inc.php';
require_once 'StartSmarty.php';

$GLOBALS["path"] = "/MagicBoulevardCinema/";

if (Installer::checkInstall()) {
    try {
        CMain::run($_SERVER["REQUEST_URI"]);
    } catch (SmartyException $e) {
        //500
    }
} else {
    try {
        Installer::start();
    } catch (SmartyException $e) {
        //500
    }
}