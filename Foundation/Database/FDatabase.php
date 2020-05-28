<?php

require_once "config.inc.php";

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
        $dbname = $GLOBALS["dbname"];
        $username = $GLOBALS["username"];
        $password = $GLOBALS["password"];

        try {
            $this->db = new PDO("mysql:dbname=" . $dbname . "; host=localhost; charset=utf8;", $username, $password);
        }
        catch (PDOException $exception) {
            VError::error(1);
            die();
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
     * @param $class
     * @param $values
     * @return
     */
    public function saveToDB($class, $values)
    {
        try {
            $this->db->beginTransaction();
            $query = "INSERT INTO " . $class::getTableName() . " VALUES " . $class::getValuesName();
            $sender = $this->db->prepare($query);
            $class::associate($sender, $values);
            $sender->execute();
            $id = $this->db->lastInsertId();
            $this->db->commit();
            return $id;
        } catch (PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
            return null;
        }
    }

    public function saveToDBDebole($class, EProiezione $proiezione, EPosto $posto)
    {
        try {
            $this->db->beginTransaction();
            $query = "INSERT INTO " . $class::getTableName() . " VALUES " . $class::getValuesName();
            $sender = $this->db->prepare($query);
            $class::associate($sender, $proiezione, $posto);
            $sender->execute();
            $id = $this->db->lastInsertId();
            $this->db->commit();
            return $id;
        } catch (PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
            return null;
        }
    }

    /**
     * @param $class
     * @param $value
     * @param string $row
     * @param null $media
     * @return array
     */
    public function loadFromDB($class, $value, string $row, $media = null) {
            try {
                $table = $media == null ? $class::getTableName() : $class::getTableName($media);
                $query = "SELECT * FROM " . $table . " WHERE " . $row . "='" . $value . "';";
                $sender = $this->db->prepare($query);
                $sender->execute();
                $returnedRows = $sender->rowCount();
                $return = [];
                if($returnedRows == 0){
                    return [];
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
                return $return;
            }
            catch (PDOException $exception) {
                echo "Errore nel Database: " . $exception->getMessage();
                return null;
            }
        }

    public function loadFromDBDebole($class, $value, string $row, $value2, $row2) {
        try {
            $query = "SELECT * FROM " . $class::getTableName() . " WHERE " . $row . "= '" . $value. "' AND " . $row2 . "= '" . $value2 . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $returnedRows = $sender->rowCount();
            $return = [];
            if($returnedRows == 0){
                return [];
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
            return $return;
        }
        catch (PDOException $exception) {
            echo "Errore nel Database: " . $exception->getMessage();
            return null;
        }
    }

    public function loadBetween($class, string $datainizio, string $datafine, string $row) {
        try {
            $query = "SELECT * FROM " . $class::getTableName() . " WHERE " . $row . " BETWEEN '" . $datainizio . "' AND '" . $datafine . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $returnedRows = $sender->rowCount();
            $return = [];
            if($returnedRows == 0){
                return [];
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
            return $return;
        }
        catch(Exception $exception) {
            echo "Errore nel Database: " . $exception->getMessage();
            return null;
        }
    }

    public function loadLike($class, string $value, string $row) {
        try {
            $query = "SELECT * FROM " . $class::getTableName() . " WHERE " . $row . " LIKE '%" . $value . "%';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $returnedRows = $sender->rowCount();
            $return = [];
            if($returnedRows == 0){
                return [];
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
        return $return;
    }
        catch(Exception $exception) {
            echo "Errore nel Database: " . $exception->getMessage();
            return null;
}
    }

    public function checkDisponibilita(int $nsala, string $data, string $oraInizioNuovoFilm) {
        try {
            $query = "SELECT * FROM Proiezione WHERE numerosala = '" . strval($nsala) . "' AND data = '" . $data . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $returnedRows = $sender->rowCount();
            $proiezioni = [];
            $output = [];
            if($returnedRows == 0){
                return [];
            }
            elseif ($returnedRows == 1) {
                array_push($proiezioni,$sender->fetch(PDO::FETCH_ASSOC));
            }
            else {
                $sender->setFetchMode(PDO::FETCH_ASSOC);
                while($elem = $sender->fetch()) {
                    $proiezioni[] = $elem;
                }
            }
            for($i=0;$i<sizeof($proiezioni);$i++) {
                $film = FFilm::load($proiezioni[$i]["idFilm"],"id");
                $durata = $film[0]->getDurataDB();
                $durata = new DateInterval($durata);
                $oraFilmPresente = $proiezioni[$i]["ora"];
                $oraFine = DateTime::createFromFormat("H:i:s",$oraFilmPresente);
                $oraFine->add($durata);
                if((strtotime($oraInizioNuovoFilm) - strtotime($oraFilmPresente) >= 0) && (strtotime($oraInizioNuovoFilm) - strtotime($oraInizioNuovoFilm)) >= 0) {
                    $salaVirtuale = FSala::loadVirtuale(strval($nsala), "nSala");
                    $data = DateTime::createFromFormat("Y-m-d",$proiezioni[$i]["data"]);
                    $proiezione = new EProiezione($film[0], $salaVirtuale, $data);
                    array_push($output, $proiezione);
                }
            }
            return $output;
        }
        catch(Exception $exception) {
            echo "Errore nel Database: " . $exception->getMessage();
            array_push($return,null);
            return null;
        }
    }

    /**
     * @param $class
     * @param $value
     * @param $row
     * @return int
     */
    public function numberofRows($class, $value, string $row) {
        $result = $this->loadFromDB($class,$value,$row);
        if($result[0] == null) {
            return null;
        }

        return sizeof($result);
    }

    /**
     * @param $class
     * @param $value
     * @param $row
     * @return bool
     */
    public function deleteFromDB($class, $value, string $row): bool {
        try{
            $this->db->beginTransaction();
            $query = "DELETE FROM " . $class::getTableName() . " WHERE " . $row . "='" . $value . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $this->db->commit();
        }
        catch(PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
            return false;
        }

        return true;
    }

    public function deleteFromDBDebole($class, $value, $row, $value2, $row2): bool {
        try{
            $this->db->beginTransaction();
            $query = "DELETE FROM " . $class::getTableName() . " WHERE " . $row . "='" . $value . "' AND ". $row2 . "= '" . $value2 . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $this->db->commit();
        }
        catch(PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
            return false;
        }

        return true;
    }

    /**
     * @param $class
     * @param $value
     * @param $row
     * @param $newRow
     * @param $newValue
     * @return bool
     */
    public function updateTheDB($class, $value, string $row, string $newRow, $newValue): bool {
        try {
            $this->db->beginTransaction();
            $query = "UPDATE " . $class::getTableName() . " SET " . $newRow . "='" . $newValue . "' WHERE " . $row . "='" . $value . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $this->db->commit();
        }
        catch(PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
            return false;
        }

        return true;
    }

    public function updateTheDBDebole($class, $value, $row, $value2, $row2, string $newRow, $newValue): bool {
        try {
            $this->db->beginTransaction();
            $query = "UPDATE " . $class::getTableName() . " SET " . $newRow . "='" . $newValue . "' WHERE " . $row . "= '" . $value. "' AND " . $row2 . "= '" . $value2 . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $this->db->commit();
        }
        catch(PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
            return false;
        }

        return true;
    }

    /**
     * @param $value
     * @param $password
     * @return object
     */
    public function loginDB(string $value, string $password) {
        if (strpos($value, '@') !== false) {
            $row = "email";
        }
        else
        {
            $row = "username";
        }
        $class = "FUtenteLoggato";
        $query = "SELECT * FROM " . $class::getTableName() . " WHERE " . $row . "='" . $value . "' AND password ='" . $password . "';";
        $sender = $this->db->prepare($query);
        $sender->execute();
        if($sender->rowCount() != 0) {
            return $sender->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }

    public function occupaPosto($proiezione, $posto, $utente, $costo) {
        try {
            $this->db->beginTransaction();
            $query = "SELECT * FROM " . "Posti" . " WHERE " . "id = '" . $proiezione->getId() . "' AND " . "posizione = '" . $posto . "' LOCK IN SHARE MODE;";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $acquisto = $sender->fetch(PDO::FETCH_ASSOC);
            $islibero = $acquisto["libero"];
            if(boolval($islibero) === true) {
                $query = "UPDATE Posti SET libero = '0' WHERE idProiezione = '" . $proiezione->getId() . "' AND posizione = '" . $posto . "';";
                $sender = $this->db->prepare($query);
                $sender->execute();
                $this->db->commit();

                $posto = EPosto::fromString($posto, false);
                $biglietto = new EBiglietto($proiezione, $posto, $utente, $costo);
                FBiglietto::save($biglietto);
                return $biglietto;
            }
        } catch(PDOException $exception) {
            $this->db->rollBack();
            echo("Errore nel Database: " . $exception->getMessage());
        }

        return null;
    }

    public function liberaPosto($idProiezione, $posto, $emailUtente) {
        try {
            $this->db->beginTransaction();
            $query = "SELECT * FROM " . "Posti" . " WHERE " . "idProiezione" . "= '" . $idProiezione. "' AND " . "posizione" . "= '" . $posto . "' LOCK IN SHARE MODE;";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $acquisto = $sender->fetch(PDO::FETCH_ASSOC);
            $islibero = $acquisto["libero"];
            $biglietto = FBiglietto::loadDoppio($idProiezione, "idProiezione", $posto, "posto");
            if(boolval($islibero) === false && ($biglietto->getUtente()->getEmail() === $emailUtente)) {
                $query = "UPDATE Posti SET libero = '1' WHERE idProiezione = '" . $idProiezione . "' AND posizione = '" . $posto . "';";
                $sender = $this->db->prepare($query);
                $sender->execute();
                $this->db->commit();
                FBiglietto::delete($idProiezione,"idProiezione",$posto,"posto");
                return true;
            }
            return false;
        } catch(PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
            return null;
        }
    }

    public function storeMedia($class, EMedia $media)
    {
        try {
            $this->db->beginTransaction();
            $query = "INSERT INTO ".$class::getTableName(get_class($media))." VALUES ".$class::getValuesName($media);
            $sender = $this->db->prepare($query);
            $class::associate($sender, $media);
            $sender->execute();
            $id=$this->db->lastInsertId();
            $this->db->commit();
            return $id;
        }
        catch(PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
            return null;
        }
    }

}