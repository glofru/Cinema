<?php

/**
 * Class CUtility
 */
class CUtility
{
    /**
     * @param int $size
     * @return array
     */
    public static function getProssimi(int $size) {
        $pm = FPersistentManager::getInstance();
        $date = EData::getDateProssime();
        $filmProssimi = $pm->loadBetween($date[0], $date[1],"EFilm");
        if(sizeof($filmProssimi) > $size) {
            array_splice($filmProssimi, 0, $size);
        }
        usort($filmProssimi, array(EFilm::class, "sortByDatesFilm"));
        $immaginiProssimi = [];
        foreach($filmProssimi as $film) {
            array_push($immaginiProssimi, $pm->load($film->getId(), "idFilm", "EMedia"));
        }
        $result = [];
        array_push($result, $filmProssimi, $immaginiProssimi);
        return $result;
    }

    /**
     * @param EUtente $utente
     * @return array
     */
    public static function getConsigliati(EUtente $utente) {
        $utente->preferences(unserialize($_COOKIE["preferences"]));
        $pm = FPersistentManager::getInstance();
        $result = [];
        if($utente->getPreferences() === true) {
            $date = EData::getDatePassate();
            $filmConsigliati = $pm->loadBetween($date[1], $date[0], "EFilm");
            shuffle($filmConsigliati);
            if(sizeof($filmConsigliati) > 6) {
                $filmConsigliati = array_slice($filmConsigliati, 0, 6);
            }
        }
        else {
            $filmConsigliati = [];
            $cookie = $utente->getPreferences();
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

    /**
     * @param array $date
     * @return array
     */
    public static function getProiezioni(array $date) {
        $pm = FPersistentManager::getInstance();
        $elencoProgrammazioni = $pm->loadBetween($date[0], $date[1], "EProiezione");

        $filmProiezioni = [];
        $immaginiProiezioni = [];
        $giudizifilm = [];
        $dateProiezioni = [];
        $punteggio = [];

        foreach($elencoProgrammazioni->getElencoprogrammazioni() as $profilm) {
            array_push($filmProiezioni, $profilm->getFilm());
            $giu = $pm->load($profilm->getFilm()->getId(), "idFilm", "EGiudizio");
            $temp = $profilm->getdateProiezioni();
            array_push($giudizifilm, $giu);
            array_push($dateProiezioni,$temp);
        }

        foreach($giudizifilm as $g) {
            if(sizeof($g) > 0) {
                $p = EGiudizio::getMedia($g);
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