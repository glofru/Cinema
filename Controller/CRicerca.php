<?php


class CRicerca
{
    public static function cercaFilm() {
        if($_SERVER['REQUEST_METHOD']=="POST") {
            $str = $_POST["filmCercato"];

            $gestore = EHelper::getInstance();

            if($str !== "") {
                $film = FPersistentManager::getInstance()->loadLike($str, "nome", "EFilm");
                $data = self::getFilmData($film);
            } else {
                $film = [];
                $data = [];

                array_push($data, [], []);
            }

            $cookie = $gestore->preferences($_COOKIE['preferences']);

            $consigliati = CHome::getConsigliati($cookie);
            $utente = CUtente::getUtente();

            $isAdmin = $utente !== null && $utente->isAdmin();

            VRicerca::showResult($film, $data[0], $data[1], $consigliati[0], $consigliati[1], $utente, $isAdmin);
        }
        else {
            CMain::methodNotAllowed();
        }
    }

    public static function cercaFilmAttributi() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $annoInizio = $_POST["anno_inizio"];
            $annoFine = $_POST["anno_fine"];
            $votoInizio = $_POST["voto_inizio"];
            $votoFine = $_POST["voto_fine"];
            $genere = $_POST["Genere"];

            $gestore = EHelper::getInstance();
            $votoInizio = $gestore->retrieveVote($votoInizio);
            $votoFine = $gestore->retrieveVote($votoFine);
            $annoInizio = $gestore->retrieveAnno($annoInizio);
            $annoFine = $gestore->retrieveAnno($annoFine);

            $pm = FPersistentManager::getInstance();
            $film = $pm->load($genere, "genere", "EFilm");

            try {
                $annoFine = DateTime::createFromFormat('Y-m-d', $annoFine . "-12-31");
            } catch (Exception $e) {
                $annoFine = new DateTime('now');
            }

            try {
                $annoInizio = DateTime::createFromFormat('Y-m-d', $annoInizio . "-01-01");
            } catch (Exception $e) {
                $annoInizio = new DateTime('now');
            }

            $film = $gestore->filter($film, floatval($votoInizio), floatval($votoFine), $annoInizio, $annoFine);
            $data = self::getFilmData($film);
            $cookie = $gestore->preferences($_COOKIE['preferences']);
            $consigliati = CHome::getConsigliati($cookie);
            $utente = CUtente::getUtente();

            VRicerca::showResult($film, $data[0], $data[1], $consigliati[0], $consigliati[1], $utente, $utente->isAdmin());
        } else {
            CMain::methodNotAllowed();
        }
    }

    private static function getFilmData(array $film): array {
        $pm = FPersistentManager::getInstance();

        $punteggi = [];
        $immaginiCercati = [];
        $giudizi = [];
        $result = [];

        foreach($film as $f) {
            array_push($immaginiCercati, $pm->load($f->getId(), "idFilm", "EMedia"));
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

        array_push($result, $immaginiCercati, $punteggi);
        return $result;
    }
}