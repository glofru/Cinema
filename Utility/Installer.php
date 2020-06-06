<?php


class Installer
{
    private static string $confDB = "configDB.conf.php";
    private static string $confCinema = "configCinema.conf.php";

    public static function checkInstall(): bool
    {
        return self::checkInstallDB() && self::checkInstallCinema() && self::checkAdmin() && self::checkPhysical();
    }

    private static function checkInstallDB(): bool {
        return file_exists(self::$confDB);
    }

    private static function checkInstallCinema(): bool {
        return file_exists(self::$confCinema);
    }

    private static function checkAdmin(): bool {
        $admin = FPersistentManager::getInstance()->load(1, 'isAdmin', "EUtente");
        return isset($admin) && sizeof($admin) > 0;
    }

    public static function checkPhysical() {
        return FPersistentManager::getInstance()->loadAllSF()> 0;
    }

    public static function start()
    {
        $smarty = StartSmarty::configuration();
        $method = $_SERVER["REQUEST_METHOD"];

        if ($method == "GET") {
            if (!self::checkInstallDB()) {
                setcookie('cookie_enabled', 'Hello, there!', time()+3600, "/");
                $smarty->display("installationDB.tpl");
            } elseif (!self::checkInstallCinema()) {
                $smarty->display("installationCinema.tpl");
            } elseif (!self::checkAdmin()) {
                $smarty->display("firstAdmin.tpl");
            } else if (!self::checkPhysical()){
                $smarty->display("firstSaleFisiche.tpl");
            } else {
                CHome::showHome();
            }
        } elseif ($method == "POST") {
            if (!self::checkInstallDB()) {
                $value = "";
                $dbname = $_POST['dbname'];
                $username = $_POST['username'];
                $pwd = $_POST['password'];
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
                    setcookie('cookie_enabled', '', time()-3600);
                    setcookie('js_enabled', '', time()-3600);
                    self::installDB($dbname, $username, $pwd, $population);
                }
            } elseif (!self::checkInstallCinema()) {
                $Mon = floatval($_POST["Mon"]);
                $Tue = floatval($_POST["Tue"]);
                $Wed = floatval($_POST["Wed"]);
                $Thu = floatval($_POST["Thu"]);
                $Fri = floatval($_POST["Fri"]);
                $Sat = floatval($_POST["Sat"]);
                $Sun = floatval($_POST["Sun"]);
                $extra = floatval($_POST["extra"]);
                self::installCinema($Mon, $Tue, $Wed, $Thu, $Fri, $Sat, $Sun, $extra);

            } elseif (!self::checkAdmin()){
                $nome = $_POST["nome"];
                $cognome = $_POST["cognome"];
                $username = $_POST["username"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                try {
                    $utente = new EAdmin($nome, $cognome, $username, $email, $password, false);
                } catch (Exception $e) {
                    header("Location: /");
                    die;
                }

                $utente->setPassword(EHelper::getInstance()->hash($password));

                $pm = FPersistentManager::getInstance();

                $pm->signup($utente);
                unset($utente);
                header("Location: /");
            } elseif (!self::checkPhysical()){
                //TODO
            } else {
                CHome::showHome();
            }
        }
    }

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
        header("Location: /");
    }

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
            header("Location: /");
        } catch (PDOException $e) {
            $db->rollBack();
            VError::error(2);
            return;
        }

        //POPULATION
        if ($population) {
            try {
                $populationFile = file_get_contents("populate.sql");

                $db->beginTransaction();
                $db->exec($populationFile);
                $db->commit();
            } catch (PDOException $e) {
                $db->rollBack();
                VError::error(2);
                return;
            }
        }

        $db = null;
        header("Location: /");
    }
}