<?php


class Installator
{
    static function checkInstall(): bool
    {
        return file_exists("config.inc.php");
    }

    static function start()
    {
        $smarty = StartSmarty::configuration();
        //check version PHP, cookie e JS
        if ($_SERVER["REQUEST_METHOD"] == "GET")
        {
            $smarty->display("installation.tpl");
        }
        else
        {
            $dbname = $_POST['dbname'];
            $user = $_POST['user'];
            $pwd = $_POST['password'];
            $db = null;
            try
            {
                $db = new PDO("mysql:host=127.0.0.1;", $user, $pwd);
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
                $file = fopen('config.inc.php', 'c+');
                $script = '<?php $GLOBALS[\'database\']= \'' . $dbname . '\'; $GLOBALS[\'username\']=  \'' . $user . '\'; $GLOBALS[\'password\']= \'' . $pwd . '\';?>';
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