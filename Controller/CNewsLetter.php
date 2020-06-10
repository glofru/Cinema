<?php


class CNewsLetter
{
    public static function sendNewsLetter() {
        if($_SERVER['REQUEST_METHOD']=="GET" && $_GET["token"] === "S3ndM34M41l") {
            $ns = FPersistentManager::getInstance()->loadAll("ENewsLetter");
            if(sizeof($ns->getListaUtenticonPreferenze()[0]) > 0) {
                $date = EData::getSettimanaProssima();
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
        if (!CUtente::isLogged() || !CUtente::getUtente()->isAdmin()) {
            CMain::forbidden();
        } else {
            $film = FPersistentManager::getInstance()->load($_SESSION["idFilm"], "id", "EFilm")[0];
            unset($_SESSION["idFilm"]);
            if (isset($film)) {
                $ns = FPersistentManager::getInstance()->loadAll("ENewsLetter");
                $pref = $film->getGenere();
                print_r($ns->getListaUtenticonPreferenze());
                foreach ($ns->getListaUtenticonPreferenze()[1] as $key => $genere) {
                    foreach ($genere as $g) {
                        if ($g === $pref) {
                            CMail::addedNewFilm($ns->getListaUtenticonPreferenze()[0][$key], $film);
                            break;
                        }
                    }
                }
            }
        }
    }
}