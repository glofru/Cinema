<?php

/**
 * Class CRicerca
 */
class CRicerca
{
    /**
     *
     */
    public static function cercaFilm() {
        if($_SERVER['REQUEST_METHOD']=="POST") {
            $str = $_POST["filmCercato"];

            if($str !== "") {
                $film = FPersistentManager::getInstance()->loadLike($str, "nome", "EFilm");
                $data = self::getFilmData($film);
            } else {
                $film = [];
                $data = [];

                array_push($data, [], []);
            }
            $utente = CUtente::getUtente();
            $consigliati = CUtility::getConsigliati($utente);

            VRicerca::showResult($film, $data[0], $data[1], $consigliati[0], $consigliati[1], $utente);
        }
        else {
            CMain::methodNotAllowed();
        }
    }

    /**
     *
     */
    public static function cercaFilmAttributi() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $genere = $_POST["genere"];
            $annoI = $_POST["anno_inizio"];
            $annoF = $_POST["anno_fine"];
            $votoInizio = floatval($_POST["voto_inizio"]);
            $votoFine = floatval($_POST["voto_fine"]);

            $annoInizio = DateTime::createFromFormat('Y-m-d', $annoI . "-01-01");
            if ($annoInizio === false) {
                $annoInizio = new DateTime('now');
            }

            $annoFine = DateTime::createFromFormat('Y-m-d', $annoF . "-12-31");
            if ($annoFine === false) {
                $annoFine = new DateTime('now');
            }

            $film = FPersistentManager::getInstance()->loadFilmByFilter(EGenere::fromString($genere), $votoInizio, $votoFine, $annoInizio, $annoFine);
            $data = self::getFilmData($film);

            $utente = CUtente::getUtente();
            $consigliati = CUtility::getConsigliati($utente);


            VRicerca::showResult($film, $data[0], $data[1], $consigliati[0], $consigliati[1], $utente, $genere, $annoI, $annoF, $votoInizio, $votoFine);
        } else {
            CMain::methodNotAllowed();
        }
    }

    //TODO: non va in CFilm?
    private static function getFilmData(array $film): array {
        $result = [];

        $pm = FPersistentManager::getInstance();

        $punteggi = [];
        $immaginiCercate = [];
        $giudizi = [];

        foreach($film as $f) {
            array_push($immaginiCercate, $pm->load($f->getId(), "idFilm", "EMedia"));
            array_push($giudizi, $pm->load($f->getId(), "idFilm", "EGiudizio"));
        }

        foreach($giudizi as $g) {
            if(sizeof($g) > 0) {
                $p = EGiudizio::getMedia($g);
            }
            else {
                $p = 0;
            }
            array_push($punteggi, $p);
        }

        if(sizeof($giudizi) == 0) {
            array_push($punteggi, 0);
        }

        array_push($result, $immaginiCercate, $punteggi);
        return $result;
    }
}