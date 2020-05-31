<?php


class CCatalogo
{
    public static function prossimeUscite() {
        $utente = CUtente::getUtente();
        $isAdmin = $utente->isAdmin();
        $result = CHome::getProssimi(20);
        $cookie = EHelper::getInstance()->preferences($_COOKIE['preferences']);
        $consigliati = CHome::getConsigliati($cookie);
        VCatalogo::prossimeUscite($result, $utente, $isAdmin, $consigliati);
    }

    public static function programmazioniPassate() {
        $utente = CUtente::getUtente();
        $isAdmin = $utente->isAdmin();
        $cookie = EHelper::getInstance()->preferences($_COOKIE['preferences']);
        $consigliati = CHome::getConsigliati($cookie);
        $film = [];
        $immagini = [];
        $punteggio = [];
        $date = [];
        $toShow = [];
        for($i=2; $i < 6; $i++) {
            $temp = EHelper::getInstance()->getSettimanaScorsa($i);
            $values = [];
            array_push($values, DateTime::createFromFormat('Y-m-d', $temp[0]), DateTime::createFromFormat('Y-m-d', $temp[1]));
            array_push($toShow, "Settimana dal " . $values[0]->format('d-m-y') . " al " . $values[1]->format('d-m-y'));
            $temp = CHome::getProiezioni($temp);
            array_push($film, $temp[0]);
            array_push($immagini, $temp[1]);
            array_push($punteggio, $temp[2]);
            array_push($date, $temp[3]);
        }
        VCatalogo::programmazioniPassate($film, $immagini, $punteggio, $date, $utente, $isAdmin, $consigliati, $toShow);
    }

    public static function piuApprezzati() {
        
    }
}