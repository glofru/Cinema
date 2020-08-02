<?php

/**
 * La classe Installer ci permette di inzializzare il sito quando viene caricato per la prima volta su un nuovo server.
 * Class Installer
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 */
class Installer
{
    /**
     * Nome del file di configurazione del DB.
     * @var string
     */
    private static string $confDB = "configDB.conf.php";
    /**
     * Nome del file di configurazione dei prezzi dei biglietti del cinema.
     * @var string
     */
    private static string $confCinema = "configCinema.conf.php";

    /**
     * Funzione che controlla se tutte le 4 componenti di installazione sono state completate.
     * @return bool
     */
    public static function checkInstall(): bool {
        return self::checkInstallDB() && self::checkInstallCinema() && self::checkAdmin() && self::checkPhysical();
    }

    /**
     * Funzione che controlla se il file di configurazione del DB è stato creato.
     * @return bool
     */
    private static function checkInstallDB(): bool {
        return file_exists(self::$confDB);
    }

    /**
     * Funzione che controlla se il file di configurazione del cinema sia stato creato.
     * @return bool
     */
    private static function checkInstallCinema(): bool {
        return file_exists(self::$confCinema);
    }

    /**
     * Funzione che controlla se un utente Admin è stato creato nel DB.
     * @return bool
     */
    private static function checkAdmin(): bool {
        $admin = FPersistentManager::getInstance()->load(1, 'isAdmin', "EUtente");
        return isset($admin) && sizeof($admin) > 0;
    }

    /**
     * Funzione che controlla se sia stata presente almeno una sala fisica nel DB.
     * @return bool
     */
    public static function checkPhysical() {
        return FPersistentManager::getInstance()->loadAllSF() > 0;
    }

    /**
     * Funzione principale che mostra le varie schermate di installazione necessarie a poter configurare correttamente l'applicazione.
     * Viene inoltre controllato se si disponga di una versione di PHP pari almeno alla 7.4.0 che i cookie siano abilitati e che il codice Javascript venga eseguito.
     * @throws SmartyException
     */
    public static function start()
    {
        $smarty = StartSmarty::configuration();
        $method = $_SERVER["REQUEST_METHOD"];

        if ($method == "GET") {
            if (!self::checkInstallDB()) {
                setcookie('cookie_enabled', 'Hello, there!', time()+3600, "/");
                $smarty->assign("path", $GLOBALS["path"]);
                $smarty->display("installationDB.tpl");
            } elseif (!self::checkInstallCinema()) {
                $smarty->assign("path", $GLOBALS["path"]);
                $smarty->display("installationCinema.tpl");
            } elseif (!self::checkAdmin()) {
                $smarty->assign("path", $GLOBALS["path"]);
                $smarty->display("firstAdmin.tpl");
            } else if (!self::checkPhysical()){
                $smarty->assign("path", $GLOBALS["path"]);
                $smarty->display("firstSaleFisiche.tpl");
            } else {
                CHome::showHome();
            }
        } elseif ($method == "POST") {
            if (!self::checkInstallDB()) {
                $value      = "";
                $dbname     = $_POST['dbname'];
                $username   = $_POST['username'];
                $pwd        = $_POST['password'];
                $population = boolval($_POST["population"]);
                if(version_compare(PHP_VERSION,'7.4.0', "<")){
                    $value .= "Versione di PHP inferiore alla 7.4.0, AGGIORNARLA per poter proseguire! <br>";
                }
                if(!isset($_COOKIE['cookie_enabled'])) {
                    $value .= "Cookie non abilitati! Per permetterci di funzionare abilitarli per favore! <br>";
                }
                if(!isset($_COOKIE['js_enabled'])) {
                    $value .= "Esecuzione di codice JS non abilitata! Per permetterci di funzionare abilitalo per favore!";
                }
                if(strlen($value) > 0) {
                    VError::error(0, $value);
                    die;
                } else {
                    setcookie('cookie_enabled', '', time()-3600, '/');
                    setcookie('js_enabled',     '', time()-3600);
                    self::installDB($dbname, $username, $pwd, $population);
                }
            } elseif (!self::checkInstallCinema()) {
                $Mon    = floatval($_POST["Mon"]);
                $Tue    = floatval($_POST["Tue"]);
                $Wed    = floatval($_POST["Wed"]);
                $Thu    = floatval($_POST["Thu"]);
                $Fri    = floatval($_POST["Fri"]);
                $Sat    = floatval($_POST["Sat"]);
                $Sun    = floatval($_POST["Sun"]);
                $extra  = floatval($_POST["extra"]);
                self::installCinema($Mon, $Tue, $Wed, $Thu, $Fri, $Sat, $Sun, $extra);

            } elseif (!self::checkAdmin()){
                $nome       = $_POST["nome"];
                $cognome    = $_POST["cognome"];
                $username   = $_POST["username"];
                $email      = $_POST["email"];
                $password   = $_POST["password"];

                try {
                    $utente = new EAdmin($nome, $cognome, $username, $email, $password, false);
                } catch (Exception $e) {
                    $smarty->assign("e", $e->getMessage());

                    $smarty->display("firstAdmin.tpl");
                    die;
                }

                FPersistentManager::getInstance()->signup($utente);

                $data   = new DateTime();
                $media  = new EMediaUtente('','',$data, '', $utente);

                FPersistentManager::getInstance()->save($media);
                unset($utente);

                header("Location: /MagicBoulevardCinema");
            } elseif (!self::checkPhysical()){
                $nSale  = [];
                $sale   = [];
                $n      = sizeof($_POST);

                if(isset($_POST["numeroSala"])){
                    $n           = $n-4;
                    $nSala       = intval($_POST["numeroSala"]);
                    $nFile       = intval($_POST["file"]);
                    $nPosti      = intval($_POST["postiPerFila"]);
                    $disponibile = boolval($_POST["disponibile"]);

                    array_push($nSale, $nSala);

                    try {
                        $sala = new ESalaFisica($nSala, $nFile, $nPosti, $disponibile);
                    } catch (Exception $e) {
                        $smarty->assign("error", $e->getMessage());

                        $smarty->display("firstSaleFisiche.tpl"); die;
                    }
                    array_push($sale, $sala);
                }
                for($i=1;$i <= $n/4;$i++) {
                     $nSala       = intval($_POST["numeroSala" . strval($i)]);
                     $nFile       = intval($_POST["file" . strval($i)]);
                     $nPosti      = intval($_POST["postiPerFila" . strval($i)]);
                     $disponibile = boolval($_POST["disponibile" . strval($i)]);

                    if(!in_array($nSala, $nSale)){
                        array_push($nSale, $nSala);
                    } else {
                        $smarty->assign("error", "Numero di sala ripetuto. Deve essere univoco");

                        $smarty->display("firstSaleFisiche.tpl"); die;
                    }

                    try {
                        $sala = new ESalaFisica($nSala, $nFile, $nPosti, $disponibile);
                    } catch (Exception $e) {
                        $smarty->assign("error", $e->getMessage());

                        $smarty->display("firstSaleFisiche.tpl"); die;
                    }

                    array_push($sale, $sala);
                }

                foreach ($sale as $item) {
                    FPersistentManager::getInstance()->save($item);
                }

                header("Location: /MagicBoulevardCinema");
            } else {
                CHome::showHome();
            }
        }
    }

    /**
     * Funzione che permette di salvare nel file di configurazione del cinema le variabili globali contenenti i costi dei biglietti per ogni giornata ed il sovrapprezzo.
     * @param float $Mon
     * @param float $Tue
     * @param float $Wed
     * @param float $Thu
     * @param float $Fri
     * @param float $Sat
     * @param float $Sun
     * @param float $extra
     */
    private static function installCinema(float $Mon, float $Tue, float $Wed, float $Thu, float $Fri, float $Sat, float $Sun, float $extra) {
        $script = '<?php ' . PHP_EOL .
            '$GLOBALS[\'extra\']= ' . $extra . ';' . PHP_EOL .
            '$GLOBALS[\'prezzi\']= [' . PHP_EOL .
            '   "Mon" => ' . $Mon . ',' . PHP_EOL .
            '   "Tue" => ' . $Tue . ',' . PHP_EOL .
            '   "Wed" => ' . $Wed . ',' . PHP_EOL .
            '   "Thu" => ' . $Thu . ',' . PHP_EOL .
            '   "Fri" => ' . $Fri . ',' . PHP_EOL .
            '   "Sat" => ' . $Sat . ',' . PHP_EOL .
            '   "Sun" => ' . $Sun  . PHP_EOL .
            '];' . PHP_EOL .
            '?>' . PHP_EOL;
        $file = fopen(self::$confCinema, 'c+');
        fwrite($file, $script);
        fclose($file);
        header("Location: /MagicBoulevardCinema");
    }

    /**
     * funzione che permette di istanziare il file di configurazione del DB con all'interno i dati necessari a potersi connettere alla base dati.
     * @param string $dbname
     * @param string $username
     * @param string $pwd
     * @param bool $population, se l'installatore ha richiesto di popolare il db con alcuni film.
     * @throws SmartyException
     */
    private static function installDB(string $dbname, string $username, string $pwd, bool $population) {
        $db = null;

        try {
            $db = new PDO("mysql:host=127.0.0.1;", $username, $pwd);
        } catch (PDOException $e) {
            VError::error(1);
            return;
        }

        try {
            $query = 'DROP DATABASE IF EXISTS ' . $dbname . '; CREATE DATABASE ' . $dbname . ' ; USE ' . $dbname . ';' . 'SET GLOBAL max_allowed_packet=16777216;';
            $query = $query . file_get_contents('db.sql');

            $db->beginTransaction();
            $db->exec($query);
            $db->commit();

            $file = fopen(self::$confDB, 'c+');
            $script = '<?php ' . PHP_EOL .
                '$GLOBALS[\'dbname\']= \'' . $dbname . '\';' . PHP_EOL .
                '$GLOBALS[\'username\']=  \'' . $username . '\';' . PHP_EOL .
                '$GLOBALS[\'password\']= \'' . $pwd . '\';' . PHP_EOL .
                '?>' . PHP_EOL;
            fwrite($file, $script);
            fclose($file);
            $dir = scandir('.');
            if(!in_array(self::$confDB, $dir)) {
                VError::error(0, "I diritti di scrittura in questa cartella ci impediscono di creare le configurazioni. Modificane i diritti e riprova."); die;
            }
        } catch (PDOException $e) {
            $db->rollBack();
            VError::error(2);
            return;
        }

        //POPULATION
        if ($population) {
            try {
                $populationFile = file_get_contents("populate.sql");
                $populationFilePart2 = file_get_contents("populatePart2.sql");
                $db->beginTransaction();
                $db->exec($populationFile);
                $db->exec($populationFilePart2);
                $db->commit();
                

            } catch (PDOException $e) {
                $db->rollBack();
                VError::error(2);
                return;
            }
        }

        header("Location: /MagicBoulevardCinema");
    }
}