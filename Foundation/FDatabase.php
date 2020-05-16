<?php


/**
 * Class FDatabase
 */
class FDatabase
{
    /**
     * @var FDatabase
     */
    private static $instance;

    /**
     * @var PDO
     */
    private PDO $db;

    /**
     * FDatabase constructor.
     */
    private function __construct() {
        try {
            $this->db = new PDO("mysql:dbname=".$GLOBALS['dbname']."host=localhost; charset=utf8;", $GLOBALS['username'],$GLOBALS['password']);
        }
        catch (PDOException $exception) {
            die("Errore nel DB: " . $exception->getMessage());
        }
    }

    /**
     * @return FDatabase
     */
    public static function getInstance(): FDatabase
    {
        if (self::$instance == null)
        {
            self::$instance = new FDatabase();
        }

        return self::$instance;
    }

    /**
     *
     */
    public function closeDBConnection () {
        static::$instance = null;
    }

    /**
     * @param $class
     * @param $values
     */
    public function saveToDB($class, $values)
    {
        try {
            $this->db->beginTransaction();
            $query = "INSERT INTO " . $class::getTables() . " VALUES " . $class::getValues();
            $sender = $this->db->prepare($query);
            $class::associate($sender, $values);
            $sender->execute();
            $this->db->commit();
            $this->closeDBConnection();
        } catch (PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
        }
    }

    /**
     * @param $class
     * @param $value
     * @param $row
     * @return array
     */
    public function loadFromDB($class, $value, $row): array {
            try {
                $query = "SELECT * FROM " . $class::getTables() . " WHERE " . $row . "='" . $value . "';";
                $sender = $this->db->prepare($query);
                $class::associate($sender,$value);
                $sender->execute();
                $returnedRows = $sender->rowCount();
                $return = [];
                if($returnedRows == 0){
                    array_push($return,null);
                }
                elseif ($returnedRows == 1) {
                    array_push($return,$sender->fetch(PDO::FETCH_ASSOC));
                }
                else {
                    $sender->setFetchMode(PDO::FETCH_ASSOC);
                    while($elem = $sender->fetch()) {
                        $return[] = $elem;
                    }
                }
                $this->closeDBConnection();
                return $return;

            }
            catch (PDOException $exception) {
                echo "Errore nel Database: " . $exception->getMessage();
                array_push($return,null);
                return $return;
            }
        }

    /**
     * @param $class
     * @param $value
     * @param $row
     * @return int
     */
    public function numberofRows($class, $value, $row): int {
        $result = $this->loadFromDB($class,$value,$row);
        if($result[0] == null) {
            return null;
        }
        else
        {
            return sizeof($result);
        }
    }

    /**
     * @param $class
     * @param $value
     * @param $row
     */
    public function deleteFromDB($class, $value, $row) {
        try{
            $this->db->beginTransaction();
            $query = "DELETE FROM " . $class::getTables() . " WHERE " . $row . "='" . $value . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $this->db->commit();
            $this->closeDBConnection();
        }
        catch(PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
        }
    }

    /**
     * @param $class
     * @param $value
     * @param $row
     * @param $newRow
     * @param $newValue
     */
    public function updateTheDB($class, $value, $row, $newRow, $newValue) {
        try {
            $this->db->beginTransaction();
            $query = "UPDATE " . $class::getTables() . " SET " . $newRow . "='" . $newValue . "' WHERE " . $row . "='" . $value . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $this->db->commit();
            $this->closeDBConnection();
        }
        catch(PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
        }
    }

    /**
     * @param $value
     * @param $password
     * @return object
     */
    public function loginDB($value, $password): object {
        if (strpos($value, '@') !== false) {
            $row = "email";
        }
        else
        {
            $row = "username";
        }
        $class = "FUtenteLoggato";
        $query = "SELECT * FROM " . $class::getTables() . " WHERE " . $row . "='" . $value . "' AND password ='" . $password . "';";
        $sender = $this->db->prepare($query);
        $sender->execute();
        if($sender->rowCount() != 0) {
            return $sender->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }


}