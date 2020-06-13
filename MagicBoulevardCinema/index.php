<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
require_once 'Utility/autoload.inc.php';
require_once 'StartSmarty.php';
$GLOBALS["path"] = "/MagicBoulevardCinema/";
if (Installer::checkInstall()) {
   CMain::run($_SERVER["REQUEST_URI"]);
} else {
    Installer::start();
}