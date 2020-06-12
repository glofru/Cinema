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

            $time = explode(":", EData::hoursandmins($_POST["durata"]));
            $durata = null;
            try {
                $durata = new DateInterval("PT" . $time[0] . "H" . $time[1] . "M");
            } catch (Exception $e) {
                $durata = new DateInterval("PT0H0M");
            }

            $trailerURL = $_POST["trailerURL"];
            $votoCritica = floatval($_POST["votoCritica"]);

            $rilascio = str_replace("/", "-", $_POST["dataRilascio"] == "" ? "01/01/1970" : $_POST["dataRilascio"]);
            echo $rilascio;
            $dataRilascio = DateTime::createFromFormat("Y-m-d", $rilascio);

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
            $status = "Utente non presente";
        } else {
            if (!$toBan->isAdmin() && !$toBan->isBanned()) {
                $pm->update($utente, "username", true, "isBanned", "EUtente");
                return null;
            } else {
                $status = "L'utente è già bannato o amministratore";
            }
        }

        return $status;
    }

    private static function unban($unban) {
        $pm = FPersistentManager::getInstance();

        $toUnban = $pm->load($unban, "id", "EUtente");

        if(!isset($toUnban)){
            $status = "Utente non presente";
        } else {
            if ($toUnban->isBanned()) {
                $pm->update($unban, "id", 0, "isBanned", "EUtente");
                return null;
            } else {
                $status = "Utente non bannato";
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

    public static function modificaFilm(){
        self::checkAdmin();
        $pm = FPersistentManager::getInstance();

        $method = $_SERVER["REQUEST_METHOD"];

        if($method == "POST"){
            $filmID = $_POST["filmId"];
            $film = $pm->load($filmID, "id", "EFilm")[0];
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
                    $pm->update($filmID,"id",$film->getDurataMinuti(),"durata","EFilm");
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
                    $rilascio = DateTime::createFromFormat('Y-m-d', $rilascio);
                    $film->setDataRilascio($rilascio);
                    $pm->update($filmID,"id",$film->getDataRilascioSQL(),"dataRilascio","EFilm");
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
                if(is_uploaded_file($_FILES["locandina"])) {
                    if (EInputChecker::getInstance()->isImage($_FILES["locandina"]["type"]) && EInputChecker::getInstance()->isLight($_FILES["locandina"]["size"])) {
                        $propic = $_FILES["locandina"];
                        $name = $propic["name"];
                        $mimeType = $propic["type"];
                        $propic = file_get_contents($propic["tmp_name"]);
                        $propic = base64_encode($propic);
                        $data = new DateTime('now');
                        $data = $data->format('Y-m-d');
                        FPersistentManager::getInstance()->update($film->getId(), "idFilm", $propic, "immagine", "EMediaLocandina");
                        FPersistentManager::getInstance()->update($film->getId(), "idFilm", $data, "date", "EMediaLocandina");
                        FPersistentManager::getInstance()->update($film->getId(), "idFilm", $name, "fileName", "EMediaLocandina");
                        FPersistentManager::getInstance()->update($film->getId(), "idFilm", $mimeType, "mimeType", "EMediaLocandina");
                    }
                }
            }catch (Exception $e){
                print $e->getMessage();
            }
            $tmp = "/Film/show/?film=" . $filmID . "&autoplay=true";
            header('Location: '.$tmp);
        } elseif ($method == "GET"){
            $filmID = $_GET["film"];

            $film = $pm->load($filmID, "id", "EFilm")[0];
            $copertina = $pm->load($filmID,"id","EMediaLocandina");

            VAdmin::modificafilm($film,$copertina);
        }
    }

    public static function gestioneSale() {
        self::checkAdmin();
        $sale = FPersistentManager::getInstance()->loadAll("ESalaFisica");

        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            VAdmin::gestioneSale($sale, CUtente::getUtente());
        } else {
            $operation = $_POST["op"];
            if($operation === '1') {
                foreach ($sale as $item) {
                    $disponibile = isset($_POST["sala" . strval($item->getNumeroSala())]);
                    if($item->isDisponibile() !== $disponibile) {
                        $item->setDisponibile($disponibile);
                        $val = $disponibile ? '1' : '0';
                        $success = FPersistentManager::getInstance()->update($item->getNumeroSala(), "nSala", $val, "disponibile", "ESalaFisica");
                        if (!$success) {
                            VError::error(2);
                            die;
                        }
                    }
                }

                VAdmin::gestioneSale($sale, CUtente::getUtente(), "Operazione avvenuta con successo!");
            } else if($operation === '2') {
                $nSala = intval($_POST["sala"]);
                $nFile = intval($_POST["file"]);
                $nPosti = intval($_POST["posti"]);
                $disponibile = isset($_POST["disponibile"]);
                try{
                    $sala = new ESalaFisica($nSala, $nFile, $nPosti, $disponibile);
                } catch (Exception $e) {
                    VAdmin::gestioneSale($sale, CUtente::getUtente(),  $e->getMessage(), $nSala>0 ? $nSala : null, $nFile>0 ? $nFile : null, $nPosti>0 ? $nPosti : null);
                    die;
                }
                foreach ($sale as $item) {
                    if($item->getNumeroSala() == $sala->getNumeroSala()) {
                        VAdmin::gestioneSale($sale, CUtente::getUtente(), "Sala già esistente!", $nSala, $nFile, $nPosti);
                        die;
                    }
                }
                FPersistentManager::getInstance()->save($sala);
                $sale = FPersistentManager::getInstance()->loadAll("ESalaFisica");
                VAdmin::gestioneSale($sale, CUtente::getUtente(), "Operazione avvenuta con successo!");
            } else {
                VError::error(0, "Azione non valida");
            }
        }
    }

    public static function gestioneProgrammazione() {
        self::checkAdmin();

        $pm = FPersistentManager::getInstance();

        $method = $_SERVER["REQUEST_METHOD"];

        if($method == "GET") {
            $films = $pm->loadAll("EFilm");
            $sale = $pm->load(true, "disponibile", "ESala");
            $utente = CUtente::getUtente();

            VAdmin::gestioneProgrammazione($utente, $films, $sale);
        } elseif ($method == "POST") {
            $idFilm = $_POST["film"];
            $nSala = $_POST["sala"];
            $orario = $_POST["orario"];
            $dataInizio = $_POST["dataInizio"];
            $dataFine = $_POST["dataFine"];

            $pm = FPersistentManager::getInstance();

            $film = $pm->load($idFilm, "id", "EFilm")[0];
            $inizio = DateTime::createFromFormat('Y-m-d', $dataInizio);
            $inizio->setTime(0, 0, 0);
            $fine = DateTime::createFromFormat('Y-m-d', $dataFine);
            $fine->setTime(0, 0, 0);
//
            if ($film === null) {
                $error = "Film non valido";
            } elseif ($orario !== null) {
                try {
                    $Hm = explode(":", $orario);
                    $ora = new DateInterval("PT{$Hm[0]}H{$Hm[1]}M");
                    $inizio->add($ora);
                    $fine->add($ora);
                } catch (Exception $e) {
                    $error = "Orario non valido";
                }
            } elseif ($inizio === false) {
                $error = "Data di inizio non valida";
            } elseif ($fine === false) {
                $error = "Data di fine non valida";
            } elseif ($fine->getTimestamp() > $inizio->getTimestamp()) {
                $error = "La data di fine è prima di quella d'inizio!";
            }

            $films = $pm->loadAll("EFilm");
            $sale = $pm->load(true, "disponibile", "ESala");
            $utente = CUtente::getUtente();
//
            $salaF = null;
            foreach ($sale as $s) {
                if ($s->getNumeroSala() == $nSala && $s->isDisponibile()) {
                    $salaF = $s;
                }
            }

            if ($salaF === null) {
                $error = "La sala non esiste o non è disponibile";
            }

            if (isset($error)) {
                VAdmin::gestioneProgrammazione($utente, $films, $sale, $film, $nSala, $orario, $dataInizio, $dataFine, $error);
                die;
            }

            $programmazione = new EProgrammazioneFilm();

            do {
                $salaV = ESalaVirtuale::fromSalaFisica($salaF);
                $proiezione = new EProiezione($film, $salaV, $inizio);
                $inizio->modify("+1 day");

                $programmazione->addProiezione($proiezione);
            } while($inizio->getTimestamp() <= $fine->getTimestamp());

            $result = $pm->saveProgrammazione($programmazione);

            if (!$result) {
                $error = "La programmazione si sovrappone con altre già esistenti";
                VAdmin::gestioneProgrammazione($utente, $films, $sale, $film, $nSala, $orario, $dataInizio, $dataFine, $error);
            }
        }
    }
}