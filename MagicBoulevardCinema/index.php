<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED); //toglie tutti i warning e alert
require_once 'Utility/autoload.inc.php'; //carica autoloader
require_once 'StartSmarty.php';// carica smarty

//ATTENZIONE: abilitare i permessi di lettura su tutta la cartella MagicBoulevardCinema
// cd /opt/lampp/htdocs
// chmod 777 -R MagicBoulevardCinema

$GLOBALS["path"] = "/MagicBoulevardCinema/"; //path globale per cambiare piu facilmente tutti path

if (Installer::checkInstall()) { //controlla installazione in installer
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