<?php


class Installer
{
    private static string $confDB = "configDB.conf.php";
    private static string $confCinema = "configCinema.conf.php";

    public static function checkInstall(): bool
    {
        return self::checkInstallDB() && self::checkInstallCinema();
    }

    private static function checkInstallDB(): bool {
        return file_exists(self::$confDB);
    }

    private static function checkInstallCinema(): bool {
        return file_exists(self::$confCinema);
    }

    public static function start()
    {
        $smarty = StartSmarty::configuration();
        $method = $_SERVER["REQUEST_METHOD"];

        //TODO: check version PHP, cookie e JS

        if ($method == "GET") {
            if (!self::checkInstallDB()) {
                $smarty->display("installationDB.tpl");
            } elseif (!self::checkInstallCinema()) {
                $smarty->display("installationCinema.tpl");
            } else {
                CHome::showHome();
            }
        } elseif ($method == "POST") {
            if (!self::checkInstallDB()) {
                $dbname = $_POST['dbname'];
                $username = $_POST['username'];
                $pwd = $_POST['password'];
                $population = boolval($_POST["population"]);
                self::installDB($dbname, $username, $pwd, $population);
            } else if (!self::checkInstallCinema()) {
                $Mon = floatval($_POST["Mon"]);
                $Tue = floatval($_POST["Tue"]);
                $Wed = floatval($_POST["Wed"]);
                $Thu = floatval($_POST["Thu"]);
                $Fri = floatval($_POST["Fri"]);
                $Sat = floatval($_POST["Sat"]);
                $Sun = floatval($_POST["Sun"]);
                $extra = floatval($_POST["extra"]);
                self::installCinema($Mon, $Tue, $Wed, $Thu, $Fri, $Sat, $Sun, $extra);
            } else {
                CHome::showHome();
            }
        }
    }

    private static function installCinema(float $Mon, float $Tue, float $Wed, float $Thu, float $Fri, float $Sat, float $Sun, float $extra) {
        $file = fopen(self::$confCinema, 'c+');
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