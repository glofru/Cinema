<?php


class CAdmin
{

    public static function addFilm()
    {
        $method = $_SERVER["REQUEST_METHOD"];
        $utente = CUtente::getUtente();
        if(!$utente->isAdmin()) {
            header("Location: /");
        }
        if ($method == "GET")
        {
            $attori = FPersistentManager::getInstance()->load("1", "isAttore", "EPersona");
            $registi = FPersistentManager::getInstance()->load("1", "isRegista", "EPersona");
            VAdmin::addFilm($attori, $registi);
        }
        elseif ($method == "POST")
        {
//            Costruzione oggetto Film
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
            $votoCritica = floatval($_POST["votoCritica"]);

            $rilascio = str_replace("/", "-", $_POST["dataRilascio"] == "" ? "01/01/1970" : $_POST["dataRilascio"]);
            $dataRilascio = DateTime::createFromFormat("d-m-Y", $rilascio);
            $paese = $_POST["paese"];
            $etaConsigliata = $_POST["etaConsigliata"];

            $film = new EFilm($titolo, $descrizione, $durata, $trailerURL, $votoCritica, $dataRilascio, $genere, $paese, $etaConsigliata);

            foreach (FFilm::recreateArray($_POST["attori"]) as $attore)
            {
                $film->addAttore($attore);
            }

            foreach (FFilm::recreateArray($_POST["registi"]) as $regista)
            {
                $film->addRegista($regista);
            }

            FPersistentManager::getInstance()->save($film);

            $tempCop = $_FILES["copertina"];
            $name = $tempCop["name"];
            $mimeType = $tempCop["type"];
            $time = new DateTime("now");
            $data = file_get_contents($tempCop["tmp_name"]);
            $data = base64_encode($data);
            $copertina = new EMediaLocandina($name, $mimeType, $time, $data, $film);
            FPersistentManager::getInstance()->save($copertina);

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

    public function gestioneUtenti() {
        $utente = CUtente::getUtente();
        $pm = FPersistentManager::getInstance();
        if(!$utente->isAdmin()) {
            header("Location: /");
        }
        if($_SERVER["REQUEST_METHOD"] === "GET") {
            $bannati = $pm->load("1","isBanned","EUtente");
            VAdmin::gestioneUtenti($bannati, $utente);
        }
        else {
            if(isset($_POST["utente"])) {
                $toBan = $pm->load($_POST["utente"],"id","EUtente")[0];
                if(!isset($toBan)) {
                    $status = 0;
                }
                else {
                    if (!$toBan->isAdmin() && !$toBan->isBanned()) {
                        $pm->update($_POST["utente"], "id", 1, "isBanned", "EUtente");
                        $status = 1;
                    } else {
                        $status = 2;
                    }
                }
            }
            else if(isset($_POST["unban"])) {
                $toUnban = $pm->load($_POST["utente"],"id","EUtente")[0];
                if(!isset($toUnban)){
                    $status = 3;
                }
                else {
                    if ($toUnban->isBanned()) {
                        $pm->update($toUnban, "id", 0, "isBanned", "EUtente");
                        $status = 1;
                    }
                    else {
                        $status = 4;
                    }
                }
            }
            $bannati = $pm->load("1","isBanned","EUtente");
            VAdmin::gestioneUtenti($bannati, $utente, $status);
            }
        }

}