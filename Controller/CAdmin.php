<?php


class CAdmin
{

    public static function checkAdmin() {
        if(!CUtente::isLogged() || !CUtente::getUtente()->isAdmin()) {
            CMain::forbidden();
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
            $_SESSION["idFilm"] = $film->getId();
            CNewsLetter::addedNewFilm();
            header("Location: /Film/show/?film=" . $film->getId());
        }
    }

    public static function addProiezione() {
        self::checkAdmin();

        $method = $_SERVER["REQUEST_METHOD"];

        $pm = FPersistentManager::getInstance();

        if ($method == "GET") {
            $films = $pm->loadAll("EFilm");
            $sale = $pm->load(true, "disponibile", "ESala");

            VAdmin::addProiezione($films, $sale);
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
            CMain::methodNotAllowed();
        }
    }

    public static function modificaPrezzi() {
        self::checkAdmin();
        if($_SERVER["REQUEST_METHOD"] === "GET") {
            VAdmin::modificaPrezzo();
        } else {
            $file = fopen('configCinema.conf.php', 'w+');
            $script = '<?php ' . PHP_EOL .
                '$GLOBALS[\'extra\']= ' . floatval($_POST["extra"]) . ';' . PHP_EOL .
                '$GLOBALS[\'prezzi\']= [' . PHP_EOL .
                '   "Mon" => ' . floatval($_POST["Mon"]) . ',' . PHP_EOL .
                '   "Tue" => ' . floatval($_POST["Tue"]) . ',' . PHP_EOL .
                '   "Wed" => ' . floatval($_POST["Wed"]) . ',' . PHP_EOL .
                '   "Thu" => ' . floatval($_POST["Thu"]) . ',' . PHP_EOL .
                '   "Fri" => ' . floatval($_POST["Fri"]) . ',' . PHP_EOL .
                '   "Sat" => ' . floatval($_POST["Sat"]) . ',' . PHP_EOL .
                '   "Sun" => ' . floatval($_POST["Sun"])  . PHP_EOL .
                '];' . PHP_EOL .
                '?>' . PHP_EOL;
            fwrite($file, $script);
            fclose($file);
            header("Location: /");
        }
    }

    public static function modificafilm(){
        self::checkAdmin();
        $pm = FPersistentManager::getInstance();
        $filmID = $_GET["film"];
        $film = $pm->load($filmID, "id", "EFilm")[0];

        $method = $_SERVER["REQUEST_METHOD"];

        if($method == "POST"){
            try {

                if(isset($_POST["nome"])){
                    $film->setNome($_POST["nome"]);
                    $pm->update($filmID,"id",$film->getNome(),"nome","EFilm");
                }

                if(isset($_POST["descrizione"])){
                    $film->setDescrizione($_POST["descrizione"]);
                    $pm->update($filmID,"id",$film->getDescrizione(),"descrizione","EFilm");
                }

                if(isset($_POST["durata"])){
                    $film->setDurata($_POST["durata"]);
                    $pm->update($filmID,"id",$film->getDurataDB(),"durata","EFilm");
                }

                if(isset($_POST["trailerURL"])){
                    $film->setTrailerURL($_POST["trailerURL"]);
                    $pm->update($filmID,"id",$film->getTrailerURL(),"trailerURL","EFilm");
                }

                if(isset($_POST["votoCritica"])){
                    $film->setvotoCritica($_POST["votoCritica"]);
                    $pm->update($filmID,"id",$film->getvotoCritica(),"votoCritica","EFilm");
                }

                if(isset($_POST["dataRilascio"])){
                    $film->setDataRilascio($_POST["dataRilascio"]);
                    $pm->update($filmID,"id",$film->getDataRilascio(),"dataRilascio","EFilm");
                }

                if(isset($_POST["genere"])){
                    $film->getGenere($_POST["genere"]);
                    $pm->update($filmID,"id",$film->getGenere(),"genere","EFilm");
                }

                if(isset($_POST["paese"])){
                    $film->setPaese($_POST["paese"]);
                    $pm->update($filmID,"id",$film->getPaese(),"paese","EFilm");
                }

                if(isset($_POST["etaConsigliata"])){
                    $film->setetaConsigliata($_POST["etaConsigliata"]);
                    $pm->update($filmID,"id",$film->getetaConsigliata(),"etaConsigliata","EFilm");
                }

                if(isset($_POST["registi"])){
                    $registi = FFilm::recreateArray($_POST["registi"]);
                    $pm->update($filmID,"id",$registi,"registi","EFilm");
                }

                if(isset($_POST["attori"])){
                    $attori = FFilm::recreateArray($_POST["attori"]);
                    $pm->update($filmID,"id",$attori,"attori","EFilm");
                }

                if(isset($_POST["locandina"])){
                    if (EInputChecker::getInstance()->isImage($_FILES[2])) {
                        $copertina = $_FILES;
                        FMedia::update($filmID, "id", $copertina, "immagine");
                    } else {
                        VError::error(10);
                    }
                }
            }catch (Exception $e){
                print $e->getMessage();
            }
        } elseif ($method == "GET"){
            $copertina = $pm->load($filmID,"id","EMediaLocandina");
            VFilm::showFilm($film, $copertina);
        }
    }
}