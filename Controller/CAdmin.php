<?php


/**
 * Nella classe Admin troviamo tutti i metodi neccessari all'amministratore per la corretta gestione del sito. Nello specifico abbiamo metodi per la gestione degli utenti, dei film, delle proiezioni, delle sale e dei costi del cinema.
 * Class CAdmin
 * Class CAcquisto
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Controller
 */
class CAdmin
{

    /**
     * Funzione privata che controlla se l'utente che sta eseguendo un operazione sia un amministratore. Nel caso non lo sia viene mostrato un 403 Forbidden.
     * Viene richiamata in tutti i metodi di questa classe.
     */
    private static function checkAdmin() {
        if(!CUtente::isLogged() || !CUtente::getUtente()->isAdmin()) {
            CMain::forbidden();
        }
    }

    /**
     * Funzione che permette di aggiungere un film nel cinema. Richiamabile via metodi GET o POST esegue le seguenti operazioni:
     *
     * GET) In questo caso viene mostrata una schermata che permette di inserire tutti i dati relativi alla creazione di un nuovo oggetto Film.
     *
     * POST) Nel caso sia una richiesta POST allora tutti i campi presenti nella schermata precedente vengono passati allo script che provvederà alla creazione delle Entity
     * necessarie a poter istanziare un nuovo Efilm.
     * Se tutti i valori passati non hanno generato eccezioni quando processate dalle entity allora il film viene aggiunto alla nostra base dati.
     * Si viene quindi portati alla pagina del nuovo film appena creato.
     */
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
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione che permette la gestione degli utenti bannati. Richiamabile sia in POST sia in GET svolge le seguenti funzioni:
     *
     * GET) Mostra la schermata dalla quale poter vedere gli utenti che sono stati bannati e la schermata che permette di bannare gli utenti.
     *
     * POST) Se viene passato in POST la variabile ban allora si sta inviando l'id dell'utente da bannare, se si passa invece unban allora si sta inviando l'id dell'utente sa unbannare.
     * Vengono quindi richiamati i due metodi associati a queste due possibilità. In caso di successo si viene reindirizzati alla pagina di gestione degli utenti.
     */
    public static function gestioneUtenti() {
        self::checkAdmin();

        $pm = FPersistentManager::getInstance();
        $utente = CUtente::getUtente();

        if($_SERVER["REQUEST_METHOD"] === "GET") {
            $bannati = $pm->loadbannati();
            VAdmin::gestioneUtenti($bannati, $utente);
        } else if ($_SERVER["REQUEST_METHOD"] === "POST"){
            if(isset($_POST["utente"])) {
                $status = self::ban($_POST["utente"]);
            } else if(isset($_POST["unban"])) {
                $status = self::unban($_POST["unban"]);
            } else {
                $status = "ERRORE: IMPOSSIBILE ESEGUIRE L'OPERAZIONE";
            }

            $bannati = $pm->loadbannati();
            VAdmin::gestioneUtenti($bannati, $utente, $status);
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione privata che effettua il ban di un utente dal database. Se l'utente è presente nel DB, non è già stato bannato e non è un admin allora il ban va a buon fine.
     * Viene tornata allora una stringa con il risultato.
     *
     * @param $utente, utente da bannare.
     * @return string|null, esito del ban.
     */
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

    /**
     * Funzione privata che effettua l'unban di un utente. Se l'utente è presente nel DB ed è stato bannato allora l'unban va a buon fine.
     * Viene quindi ritornata una stringa con il risultato.
     *
     * @param $unban, utente da unbannare.
     * @return string|null, esito dell'unban.
     */
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

    /**
     * Funzione accessibile solo via metodo POST permette, nel caso in cui un utente abbia espresso un giudizio non consono, di cancellare il commento effettuato ed in contemporanea di bannare l'utente.
     */
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

    /**
     * Funzione accessibile via GET e POST che permette di modificare i prezzi dei biglietti e del sovrapprezzo del cinema. La funzione esegue i seguenti passaggi:
     *
     * GET) Viene mostrata la pagina di modifica dei prezzi.
     *
     * POST) Vengono raccolti tutti i prezzi passati via post ed inseriti in un file (configCinema.conf.php) in modo tale da poter assegnare i prezzi ad altrettante variabili globali per poter essere accessibili in tutti gli script.
     */
    public static function modificaPrezzi() {
        self::checkAdmin();
        if($_SERVER["REQUEST_METHOD"] === "GET") {
            VAdmin::modificaPrezzo();
        } else if($_SERVER["REQUEST_METHOD"] === "POST") {
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
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione che permette di effettuare modifiche su un film. Accessibile via GET e POST il metodo esegue i seguenti passaggi:
     *
     * GET) Viene mostrata la pagina di modifica relativa al film selezionato.
     *
     * POST) Vengono passati allo script tutti i parametri del film che è stato modificato. Ogni parametro è poi aggiornato nel relativo campo del film sul DB.
     * Al termine, in mnacanza di errori, si viene riporati alla pagina del film.
     */
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
                    $rilascio = DateTime::createFromFormat('Y-m-d', $_POST["dataRilascio"]);
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
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione accessibile sia via GET sia via POST permette di gestire le varie saledi cui dispone il cinema. La funzione svolge le seguenti funzioni:
     *
     * GET) Viene mostrata la schermata di gestione e aggiunta di una sala.
     *
     * POST) Se viene passato il parametro op con valore 1 allora si aggiorna la disponibilità delle sale presnrti, sulla base dei numeri di sala che sono stati inviati.
     * Se invece op è impostato a 2 allora viene creata una nuova sala sulla base dei valori inviati dall'utente. Se l'entità sala non genera un eccezione a casua di parametri non validi l'operazione va a buon fine.
     * Qualsiasi altro valore di op genera un errore.
     */
    public static function gestioneSale() {
        self::checkAdmin();
        $sale = FPersistentManager::getInstance()->loadAll("ESalaFisica");

        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            VAdmin::gestioneSale($sale, CUtente::getUtente());
        } elseif($_SERVER["REQUEST_METHOD"] === "POST") {
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
        } else {
            CMain::methodNotAllowed();
        }
    }

    //TODO
    /**
     * Funzione accessibile solo via metodo POST permette di
     */
    public static function gestioneProgrammazione() {
        self::checkAdmin();

        $pm = FPersistentManager::getInstance();

        $films = $pm->loadAll("EFilm");
        $sale = $pm->load(true, "disponibile", "ESala");
        $utente = CUtente::getUtente();
        $film = null;
        $nSala = null;
        $orario = null;
        $dataInizio = null;
        $dataFine = null;
        $error = null;

        $method = $_SERVER["REQUEST_METHOD"];
        if ($method == "POST") {
            $idFilm = $_POST["film"];
            $nSala = $_POST["sala"];
            $orario = $_POST["orario"];
            $dataInizio = $_POST["dataInizio"];
            $dataFine = $_POST["dataFine"];

            $pm = FPersistentManager::getInstance();

            $film = $pm->load($idFilm, "id", "EFilm")[0];
            $inizio = DateTime::createFromFormat('Y-m-d', $dataInizio);
            $fine = DateTime::createFromFormat('Y-m-d', $dataFine);

            if ($film === null) {
                $error = "Film non valido";
            } elseif ($orario !== null) {
                try {
                    $Hm = explode(":", $orario);
                    $ora = new DateInterval("PT{$Hm[0]}H{$Hm[1]}M");
                    $inizio->setTime(0, 0, 0);
                    $fine->setTime(0, 0, 0);
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

            $salaF = null;
            foreach ($sale as $s) {
                if ($s->getNumeroSala() == $nSala && $s->isDisponibile()) {
                    $salaF = $s;
                }
            }

            if ($salaF === null) {
                $error = "La sala non esiste o non è disponibile";
            }

            if ($error === null) {
                $programmazione = new EProgrammazioneFilm();
                do {
                    $salaV = ESalaVirtuale::fromSalaFisica($salaF);
                    $proiezione = new EProiezione($film, $salaV, $inizio);
                    $inizio->modify("+1 day");

                    $programmazione->addProiezione($proiezione);
                } while ($inizio->getTimestamp() <= $fine->getTimestamp());

                $result = $pm->saveProgrammazione($programmazione);

                if (!$result) {
                    $error = "La programmazione si sovrappone con altre già esistenti";
                } else {
                    $programmazioni = $pm->loadAll("EElencoProgrammazioni");
                    $locandine = [];
                    foreach($programmazioni->getElencoProgrammazioni() as $prog) {
                        array_push($locandine, $pm->load($prog->getFilm()->getId(), "idFilm", "EMedia"));
                    }
                    $film = null;
                    $nSala = null;
                    $orario = null;
                    $dataInizio = null;
                    $dataFine = null;
                    $error = null;
                }
            }
        } else {
            CMain::methodNotAllowed();
        }

        $programmazioni = $pm->loadAll("EElencoProgrammazioni");
        $locandine = [];
        foreach($programmazioni->getElencoProgrammazioni() as $prog) {
            array_push($locandine, $pm->load($prog->getFilm()->getId(), "idFilm", "EMedia"));
        }

        VAdmin::gestioneProgrammazione($utente, $films, $sale, $programmazioni, $locandine, $film, $nSala, $orario, $dataInizio, $dataFine, $error);
    }

    public static function modificaProgrammazione() {
        self::checkAdmin();

        $method = $_SERVER["REQUEST_METHOD"];

        if ($method === "GET") {
            $idFilm = $_GET["film"];
            $utente = CUtente::getUtente();
            $programmazione = FPersistentManager::getInstance()->load($idFilm, "idFilm", "EProgrammazione")->getElencoProgrammazioni()[0];

            VAdmin::modificaProgrammazione($utente, $programmazione);
        }
    }
}