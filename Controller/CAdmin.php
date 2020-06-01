<?php


class CAdmin
{

    public static function checkAdmin() {
        if(!CUtente::isLogged() || !CUtente::getUtente()->isAdmin()) {
            VError::error(3);
            die;
        }
    }

    public static function addFilm() {
        self::checkAdmin();

        $method = $_SERVER["REQUEST_METHOD"];

        if ($method == "GET") {
            $attori = FPersistentManager::getInstance()->load("1", "isAttore", "EPersona");
            $registi = FPersistentManager::getInstance()->load("1", "isRegista", "EPersona");
            VAdmin::addFilm($attori, $registi);
        } elseif ($method == "POST") {
//            Costruzione oggetto Film
            $titolo = $_POST["titolo"];
            $descrizione = $_POST["descrizione"];
            $genere = EGenere::fromString($_POST["genere"]);

            $time = explode(":", EHelper::getInstance()->hoursandmins($_POST["durata"]));
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

            foreach (FFilm::recreateArray($_POST["attori"]) as $attore) {
                $film->addAttore($attore);
            }

            foreach (FFilm::recreateArray($_POST["registi"]) as $regista) {
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

    public static function gestioneUtenti() {
        self::checkAdmin();

        $pm = FPersistentManager::getInstance();
        $utente = CUtente::getUtente();

        if($_SERVER["REQUEST_METHOD"] === "GET") {
            $bannati = $pm->loadbannati();
            VAdmin::gestioneUtenti($bannati, $utente);
        } else {
            if(isset($_POST["utente"])) {
                $status = self::ban($_POST["utente"]);
            } else if(isset($_POST["unban"])) {
                $status = self::unban($_POST["unban"]);
            } else {
                $status = "ERRORE: IMPOSSIBILE ESEGUIRE L'OPERAZIONE";
            }

            $bannati = $pm->loadbannati();
            VAdmin::gestioneUtenti($bannati, $utente, $status);
        }
    }

    private static function ban($utente) {
        $pm = FPersistentManager::getInstance();

        $toBan = $pm->load($utente,"username","EUtente");

        if(!isset($toBan)) {
            $status = "ERRORE: UTENTE NON PRESENTE NEL DATABASE!";
        } else {
            if (!$toBan->isAdmin() && !$toBan->isBanned()) {
                $pm->update($utente, "username", true, "isBanned", "EUtente");
                $status = "OPERAZIONE RIUSCITA!";
            } else {
                $status = "ERRORE: L'UTENTE SELEZIONATO È GIÀ BANNATO OPPURE UN AMMINISTRATORE!";
            }
        }

        return $status;
    }

    private static function unban($unban): string {
        $pm = FPersistentManager::getInstance();

        $toUnban = $pm->load($unban, "id", "EUtente");

        if(!isset($toUnban)){
            $status = "ERRORE: UTENTE NON PRESENTE NEL DATABASE!";
        } else {
            if ($toUnban->isBanned()) {
                $pm->update($unban, "id", 0, "isBanned", "EUtente");
                $status = "OPERAZIONE RIUSCITA!";
            } else {
                $status = "ERRORE: UTENTE NON BANNATO!";
            }
        }

        return $status;
    }

    public static function deleteAndBan() {
        self::checkAdmin();

        $method = $_SERVER["REQUEST_METHOD"];

        if ($method == "POST") {
            self::ban($_POST["utente"]);
            CGiudizio::delete();
        } else {
            CMain::notFound();
        }
    }
}