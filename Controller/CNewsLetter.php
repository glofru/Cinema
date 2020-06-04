<?php


class CNewsLetter
{
    public static function sendNewsLetter() {
        if($_SERVER['REQUEST_METHOD']=="GET" && $_GET["token"] === "S3ndM34M41l") {
            $ns = FPersistentManager::getInstance()->loadAll();
            if(sizeof($ns->getListaUtenticonPreferenze()[0]) > 0) {
                $date = EHelper::getInstance()->getSettimanaProssima();
                $results = CHome::getProiezioni($date);
                foreach ($ns->getListaUtenticonPreferenze()[0] as $utente) {
                    CMail::newsLetter($utente, $date, $results);
                }
            }
        } else {
            CMain::methodNotAllowed();
        }
    }

    public static function addedNewFilm() {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            if(!CUtente::isLogged() || !CUtente::getUtente()->isAdmin()) {
                VError::error(9);
                die;
            } else {
                $film = FPersistentManager::getInstance()->load($_POST["idFilm"], "id", "EFilm");
                if(isset($film)) {
                    $ns = FPersistentManager::getInstance()->loadAll();
                    $pref = EGenere::fromString($_POST["genere"]);
                    foreach ($ns->getListaUtenticonPreferenze()[1] as $key => $genere) {
                        foreach ($genere as $g) {
                            if($g === $pref) {
                                CMail::addedNewFilm($ns->getListaUtenticonPreferenze()[0][$key], $film);
                                break;
                            }
                        }
                    }
                }
            }
        } else {
            CMain::methodNotAllowed();
        }
    }
}