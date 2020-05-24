<?php


class CAdmin
{

    public static function addFilm()
    {
        $method = $_SERVER["REQUEST_METHOD"];

        if ($method == "GET")
        {
            VAdmin::addFilm();
        }
        elseif ($method == "POST")
        {
            $titolo = $_POST["titolo"];
            $descrizione = $_POST["descrizione"];
            $genere = EGenere::fromString($_POST["genere"]);

            $time = explode(":", self::hoursandmins($_POST["durata"]));
            $durata = null;
            try {
                $durata = new DateInterval("PT" . $time[0] . "H" . $time[1] . "M");
            } catch (Exception $e) {
                $durata = new DateInterval("PT0H0M");
            }

            $trailerURL = $_POST["trailerURL"];
            $votoCritica = $_POST["votoCritica"];

            $rilascio = str_replace("/", "-", $_POST["dataRilascio"]);
            $dataRilascio = DateTime::createFromFormat("d-m-Y", $rilascio);
            $paese = $_POST["paese"];
            $etaConsigliata = $_POST["etaConsigliata"];

            $film = new EFilm($titolo, $descrizione, $durata, $trailerURL, $votoCritica, $dataRilascio, $genere, $paese, $etaConsigliata);
            FPersistentManager::getInstance()->save($film);
            header("Location: /Film/show/?film=" . $film->getId());
        }
    }

//    StackOverflow
    private static function hoursandmins($time, $format = '%02d:%02d')
    {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

}