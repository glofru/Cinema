<?php


class CNewsLetter
{
    public static function sendNewsLetter() {
        if($_SERVER['REQUEST_METHOD']=="GET" && $_GET["token"] === "S3ndM34M41l") {
            $ns = FPersistentManager::getInstance()->loadAll();
            if(isset($utenti) && sizeof($utenti) > 0) {
                $date = EHelper::getInstance()->getSettimanaProssima();
                $results = CHome::getProiezioni($date);
                foreach ($ns->getListaUtenticonPreferenze()[0] as $utente) {
                    CMail::newsLetter($utente, $date, $results);
                }
            }
        }
    }
}