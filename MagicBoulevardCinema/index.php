<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
require_once 'Utility/autoload.inc.php';
require_once 'StartSmarty.php';

//ATTENZIONE: abilitare i permessi di lettura su tutta la cartella MagicBoulevardCinema
// cd /opt/lampp/htdocs
// chmod 777 -R MagicBoulevardCinema

$GLOBALS["path"] = "/MagicBoulevardCinema/";

if (Installer::checkInstall()) {
    try {
        CMain::run($_SERVER["REQUEST_URI"]);
    } catch (SmartyException $e) {
        CMain::internalServerError();
    }
} else {
    try {
        Installer::start();
    } catch (SmartyException $e) {
        CMain::internalServerError();
    }
}