<?php


class CCatalogo
{
    public static function prossimeUscite() {
        $utente = CUtente::getUtente();
        if(isset($utente))
            $isAdmin = $utente->isAdmin();
        else
            $isAdmin = false;
        $result = CHome::getProssimi(20);
        $cookie = EHelper::getInstance()->preferences($_COOKIE['preferences']);
        $consigliati = CHome::getConsigliati($cookie);
        VCatalogo::prossimeUscite($result, $utente, $isAdmin, $consigliati);
    }

    public static function programmazioniPassate() {
        $utente = CUtente::getUtente();
        if(isset($utente))
            $isAdmin = $utente->isAdmin();
        else
            $isAdmin = false;
        $cookie = EHelper::getInstance()->preferences($_COOKIE['preferences']);
        $consigliati = CHome::getConsigliati($cookie);
        $film = [];
        $immagini = [];
        $punteggio = [];
        $date = [];
        $toShow = [];
        for($i=2; $i < 6; $i++) {
            $temp = EData::getSettimanaScorsa($i);
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
        $utente = CUtente::getUtente();

        if(isset($utente)) {
            $isAdmin = $utente->isAdmin();
        } else {
            $isAdmin = false;
        }

        $cookie = EHelper::getInstance()->preferences($_COOKIE['preferences']);
        $consigliati = CHome::getConsigliati($cookie);
        $oggi = EData::getDateProssime();
        $film = FPersistentManager::getInstance()->loadBetween('0000-00-00', $oggi[0], "EFilm");

        $punteggi = [];

        foreach($film as $item){
            $giudizi = FPersistentManager::getInstance()->load($item->getId(),"idFilm","EGiudizio");

            if(sizeof($giudizi) === 0) {
                $p = 0;
            } else {
                $p = EGiudizio::getMedia($giudizi);
            }

            $punteggi[$item->getId()] = $p;
        }

        $res = arsort($punteggi);
        if(sizeof($punteggi) > 10) {
            array_splice($punteggi, 0, 10);
        }

        $filmApprezzati = [];
        $immaginiApprezzati = [];

        foreach ($punteggi as $key => $p) {
            foreach ($film as $f) {
                if($f->getId() == $key){
                    array_push($filmApprezzati, $f);
                    array_push($immaginiApprezzati, FPersistentManager::getInstance()->load($key, "idFilm", "EMedia"));
                    break;
                }
            }

        }

        $result = [];
        array_push($result, $filmApprezzati, $immaginiApprezzati, $punteggi);

        VCatalogo::piuApprezzati($result, $utente, $isAdmin, $consigliati);
    }
}