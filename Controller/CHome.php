<?php
class CHome
{

    public static function showHome() {
        $gestore = EHelper::getInstance();
        $cookie = $gestore->preferences($_COOKIE['preferences']);
        $prossimi = self::getProssimi();
        $consigliati = self::getConsigliati($cookie);
        $proiezioni = self::getProiezioni($gestore->getSettimana(), $gestore);
        $prossima = self::getProiezioni($gestore->getSettimanaProssima(), $gestore);
        $scorsa = self::getProiezioni($gestore->getSettimanaScorsa(), $gestore);

        $utente = CUtente::getUtente();
        $isAdmin = $utente != null && $utente->isAdmin();
        VHome::showHome($prossimi[0], $prossimi[1], $consigliati[0], $consigliati[1], $proiezioni[0], $proiezioni[1], $proiezioni[2], $proiezioni[3], $scorsa[0], $scorsa[1], $scorsa[2], $scorsa[3], $prossima[0], $prossima[1], $prossima[2], $prossima[3], $utente, $isAdmin);
    }

    private static function getProssimi() {
        $pm = FPersistentManager::getInstance();
        $date = EHelper::getInstance()->getDateProssime();
        $filmProssimi = $pm->loadBetween($date[0], $date[1],"EFilm");
        $immaginiProssimi = [];
        foreach($filmProssimi as $film) {
            array_push($immaginiProssimi, $pm->load($film->getId(), "idFilm", "EMedia"));
        }
        $result = [];
        array_push($result, $filmProssimi, $immaginiProssimi);
        return $result;
    }

    public static function getConsigliati($cookie) {
        $pm = FPersistentManager::getInstance();
        $result = [];
        if(EHelper::getInstance()->getPreferences($cookie) === true) {
            $date = EHelper::getInstance()->getDatePassate();
            $filmConsigliati = $pm->loadBetween($date[1], $date[0], "EFilm");
            shuffle($filmConsigliati);
            if(sizeof($filmConsigliati) > 6) {
                $filmConsigliati = array_slice($filmConsigliati, 0, 6);
            }
        }
        else {
            $filmConsigliati = [];
            foreach($cookie as $key => $c) {
                if($c !== 0) {
                    $f = $pm->load($key, "Genere", "EFilm");
                    shuffle($f);
                    if(sizeof($f) > $c) {
                        $f = array_slice($f, 0,$c);
                    }
                    foreach($f as $elem) {
                        array_push($filmConsigliati, $elem);
                    }
                }
            }
        }
        $immaginiConsigliati = [];
        foreach($filmConsigliati as $film) {
            array_push($immaginiConsigliati, $pm->load($film->getId(), "idFilm", "EMedia"));
        }
        array_push($result, $filmConsigliati, $immaginiConsigliati);
        return $result;
    }

    public static function getProiezioni(array $date, EHelper $gestore) {
        $pm = FPersistentManager::getInstance();
        $elencoprogrammazioni = $pm->loadBetween($date[0], $date[1], "EProiezione");
        $filmProiezioni = [];
        $immaginiProiezioni = [];
        $giudizifilm = [];
        $dateProiezioni = [];
        $punteggio = [];
        foreach($elencoprogrammazioni->getElencoprogrammazioni() as $profilm) {
            array_push($filmProiezioni, $profilm->getFilm());
            $giu = $pm->load($profilm->getFilm()->getId(), "idFilm", "EGiudizio");
            $temp = $profilm->getdateProiezioni();
            array_push($giudizifilm, $giu);
            array_push($dateProiezioni,$temp);
        }
        
        foreach($giudizifilm as $g) {
            if(sizeof($g) > 0) {
                $p = $gestore->getMedia($g);
            }
            else {
                $p = 0;
            }
            array_push($punteggio, $p);
        }
        foreach($filmProiezioni as $film) {
            array_push($immaginiProiezioni, $pm->load($film->getId(), "idFilm", "EMedia"));
        }
        $result = [];
        array_push($result, $filmProiezioni, $immaginiProiezioni, $punteggio, $dateProiezioni);
        return $result;
    }
}
?>