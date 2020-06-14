<?php

/**
 * La classe Utility contiene alcuni metodi sfruttati da altre classi controller per reperire alcuni oggetti utili al fine di una corretta visualizzazione della pagna.
 * Class CUtility
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Controller
 */
class CUtility
{
    /**
     * Funzione che restituisce un numero variabile (size) di film in prossima uscita. Insieme a questi sono restituite anche le relative locandine.
     * @param int $size, numero dei film di prossima uscita che si richiede.
     * @return array, insieme di film e locandine.
     */
    public static function getProssimi(int $size)
    {
        $pm               = FPersistentManager::getInstance();
        $date             = EData::getDateProssime();
        $filmProssimi     = $pm->loadBetween($date[0], $date[1], "EFilm");

        usort($filmProssimi, array(EFilm::class, "sortByDatesFilm"));
        if (sizeof($filmProssimi) > $size) {
            $filmProssimi = array_splice($filmProssimi, 0, $size);
        }

        $immaginiProssimi = [];
        foreach ($filmProssimi as $film) {
            array_push($immaginiProssimi, $pm->load($film->getId(), "idFilm", "EMedia"));
        }

        $result = [];
        array_push($result, $filmProssimi, $immaginiProssimi);

        return $result;
    }

    /**
     * Funzione che dato il cookie "preferences" indidividua i generi preferiti dall'utente e quindi un insieme di film da mostrare. Se il cookie è 'vuoto' allora viene mostrata una scelta di 6 film casuali.
     * @param EUtente $utente, utente dal quale reperire le preferenze.
     * @return array, insieme di film e locandine.
     */
    public static function getConsigliati(EUtente $utente) {
        $pm = FPersistentManager::getInstance();

        $utente->preferences($_COOKIE["preferences"]);

        $result   = [];
        if($utente->getPreferences() === true) {
            $date = EData::getDatePassate();
            $filmConsigliati = $pm->loadBetween($date[1], $date[0], "EFilm");

            shuffle($filmConsigliati);
            if(sizeof($filmConsigliati) > 6) {
                $filmConsigliati = array_slice($filmConsigliati, 0, 6);
            }
        } else {
            $filmConsigliati = [];
            $cookie          = $utente->getPreferences();

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
     * Funzione che permette, dato un intervallo di date, di ottenere tutti i film con almeno una proiezione nell'intervallo scelto.
     * @param array $date, intervallo di date da cinsiderare.
     * @return array, insieme di film, locandine, punteggio medio delle recensioni per ogni film e date delle proiezioni per ogni film.
     */
    public static function getProiezioni(array $date) {
        $pm = FPersistentManager::getInstance();
        $elencoProgrammazioni = $pm->loadBetween($date[0], $date[1], "EProiezione");

        $filmProiezioni     = [];
        $immaginiProiezioni = [];
        $giudizifilm        = [];
        $dateProiezioni     = [];
        $punteggio          = [];

        foreach($elencoProgrammazioni->getElencoprogrammazioni() as $profilm) {
            array_push($filmProiezioni, $profilm->getFilm());

            $giu = $pm->load($profilm->getFilm()->getId(), "idFilm", "EGiudizio");
            $temp = $profilm->getDateProiezione();

            array_push($giudizifilm, $giu);
            array_push($dateProiezioni,$temp);
        }

        foreach($giudizifilm as $g) {
            if(sizeof($g) > 0) {
                $p = EGiudizio::getMedia($g);
            } else {
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