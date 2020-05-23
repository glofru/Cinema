<?php


class Installer
{
    static function checkInstall(): bool
    {
        return file_exists("config.inc.php");
    }

    static function start()
    {
        $smarty = StartSmarty::configuration();
        $method = $_SERVER["REQUEST_METHOD"];
        //TODO: check version PHP, cookie e JS
        if ($method == "GET")
        {
            $smarty->display("installation.tpl");
        }
        elseif ($method == "POST")
        {
            $dbname = $_POST['dbname'];
            $username = $_POST['username'];
            $pwd = $_POST['password'];

            $db = null;
            try
            {
                $db = new PDO("mysql:host=127.0.0.1;", $username, $pwd);
            }
            catch (PDOException $e)
            {
                VError::error(1);
                die;
            }

            try
            {
                $db->beginTransaction();
                $query = 'DROP DATABASE IF EXISTS ' . $dbname . '; CREATE DATABASE ' . $dbname . ' ; USE ' . $dbname . ';' . 'SET GLOBAL max_allowed_packet=16777216;';
                $query = $query . file_get_contents('db.sql');
                $db->exec($query);
                $db->commit();

                //REMOVE
                $population = file_get_contents("populate.sql");
                $db->beginTransaction();
                $db->exec($population);
                $db->commit();

                $file = fopen('config.inc.php', 'c+');
                $script = '<?php $GLOBALS[\'dbname\']= \'' . $dbname . '\'; $GLOBALS[\'username\']=  \'' . $username . '\'; $GLOBALS[\'password\']= \'' . $pwd . '\';?>';
                fwrite($file, $script);
                fclose($file);
                $db=null;
                header("Location: /");
            }
            catch (PDOException $e)
            {
                $db->rollBack();
                VError::error(2);
                die;
            }
        }
    }
}