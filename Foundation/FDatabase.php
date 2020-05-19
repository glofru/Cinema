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
     * @param $class
     * @param $values
     * @return
     */
    public function saveToDB($class, $values)
    {
        try {
            $this->db->beginTransaction();
            $query = "INSERT INTO " . $class::getTables() . " VALUES " . $class::getValues();
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

    public function saveToDBPosti($class, EProiezione $proiezione, EPosto $posto)
    {
        try {
            $this->db->beginTransaction();
            $query = "INSERT INTO " . $class::getTables() . " VALUES " . $class::getValues();
            $sender = $this->db->prepare($query);
            $class::associate($sender, $$proiezione, $posto);
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
     * @param $row
     * @return array
     */
    public function loadFromDB($class, $value, string $row) {
            try {
                $query = "SELECT * FROM " . $class::getTables() . " WHERE " . $row . "='" . $value . "';";
                $sender = $this->db->prepare($query);
                $class::associate($sender,$value);
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
            $query = "SELECT * FROM " . $class::getTables() . "' WHERE " . $row . "= '" . $value. "' AND " . $row2 . "= '" . $value2 . "';";
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
            return $return;
        }
        catch (PDOException $exception) {
            echo "Errore nel Database: " . $exception->getMessage();
            return null;
        }
    }

    public function loadBetweenProiezione(string $datainizio, string $datafine) {
        try {
            $query = "SELECT * FROM Proiezioni WHERE Data BETWEEN '" . $datainizio . "' AND '" . $datafine . "';";
            $sender = $this->db->prepare($query);
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
            return $return;
        }
        catch(Exception $exception) {
            echo "Errore nel Database: " . $exception->getMessage();
            array_push($return,null);
            return null;
        }
    }

    public function checkDisponibilita(int $nsala, string $data, string $oraInizioNuovoFilm) {
        try {
            $query = "SELECT * FROM Proiezioni WHERE numeroSala = '" . strval($nsala) . "' AND data = '" . $data . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $returnedRows = $sender->rowCount();
            $result = [];
            $output = [];
            if($returnedRows == 0){
                array_push($return,null);
                return $return;
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
            for($i=0;$i<sizeof($return);$i++) {
                $result = $this->loadFromDB("FFilm",$return[$i]["id"],"id");
                $durata = $result["durata"];
                $durata = new DateInterval($durata);
                $oraFilmPresente = $return[$i]["ora"];
                $oraFineFilmPresente = new DateTime('1970-01-01T' . $oraFilmPresente);
                $oraFineFilmPresente = $oraFineFilmPresente->add($durata);
                $oraFineFilmPresente = $oraFineFilmPresente->format('h:i:s');
                if((strtotime($oraInizioNuovoFilm) - strtotime($oraFilmPresente) > 0) && (strtotime($oraFineFilmPresente) - strtotime($oraInizioNuovoFilm) > 0)) {
                    array_push($output,new EProiezione(FFilm::load($return[$i]["id"],"id"), ESalaVirtuale::fromSalaFisica(FSalaFisica::load($nsala,"numeroSala")),new DateTime($return["data"])));
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
    public function numberofRows(string $class, $value, string $row): int {
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
     * @return bool
     */
    public function deleteFromDB(string $class, $value, string $row): bool {
        try{
            $this->db->beginTransaction();
            $query = "DELETE FROM " . $class::getTables() . " WHERE " . $row . "='" . $value . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $this->db->commit();
            return true;
        }
        catch(PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
            return false;
        }
    }

    public function deleteFromDBDebole(string $class, $value, $row, $value2, $row2): bool {
        try{
            $this->db->beginTransaction();
            $query = "DELETE FROM " . $class::getTables() . " WHERE " . $row . "='" . $value . "' AND ". $row2 . "= '" . $value2 . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $this->db->commit();
            return true;
        }
        catch(PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
            return false;
        }
    }

    /**
     * @param $class
     * @param $value
     * @param $row
     * @param $newRow
     * @param $newValue
     * @return bool
     */
    public function updateTheDB(string $class, $value, string $row, string $newRow, $newValue): bool {
        try {
            $this->db->beginTransaction();
            $query = "UPDATE " . $class::getTables() . " SET " . $newRow . "='" . $newValue . "' WHERE " . $row . "='" . $value . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $this->db->commit();
            return true;
        }
        catch(PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
            return false;
        }
    }

    public function updateTheDBDebole(string $class, $value, $row, $value2, $row2, string $newRow, $newValue): bool {
        try {
            $this->db->beginTransaction();
            $query = "UPDATE " . $class::getTables() . " SET " . $newRow . "='" . $newValue . "' WHERE " . $row . "= '" . $value. "' AND " . $row2 . "= '" . $value2 . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $this->db->commit();
            return true;
        }
        catch(PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
            return false;
        }
    }

    /**
     * @param $value
     * @param $password
     * @return object
     */
    public function loginDB(string $value, string $password): object {
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

    public function occupaPosto($idProiezione,$posto,$emailUtente,$costo) {
        try {
            $this->db->beginTransaction();
            $query = "SELECT * FROM Posti WHERE idProiezione = '" . $idProiezione . "' AND posto = '" . $posto . "' LOCK IN SHARE MODE";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $acquisto = $sender->fetch(PDO::FETCH_ASSOC);
            $islibero = $acquisto["libero"];
            if(boolval($islibero) === true) {
                $query = "UPDATE Posti SET libero = 'TRUE' WHERE idProiezione = '" . $idProiezione . "' AND posto = '" . $posto . "' LOCK IN SHARE MODE";
                $sender = $this->db->prepare($query);
                $sender->execute();
                $this->db->commit();
                $utente = FUtente::loadEmail($emailUtente);
                $posto = EPosto::fromString($posto,"false");
                $proiezione = FProiezioni::load($idProiezione,"id",true,null,null);
                $proiezione = $proiezione[0];
                $biglietto = new EBiglietto($proiezione,$posto,$utente,$costo);
                FBiglietti::save($biglietto);
                return $biglietto;
            }
            return null;
        } catch(PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
            return null;
        }
    }

    public function liberaPosto($idProiezione,$posto, $emailUtente) {
        try {
            $this->db->beginTransaction();
            $query = "SELECT * FROM Posti WHERE idProiezione = '" . $idProiezione . "' AND posto = '" . $posto . "' LOCK IN SHARE MODE";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $acquisto = $sender->fetch(PDO::FETCH_ASSOC);
            $islibero = $acquisto["libero"];
            $biglietto = FBiglietti::loadDoppio($idProiezione,"idProiezione",$posto,"posto");
            if(boolval($islibero) === false && ($biglietto->getUtente()->getEmail() === $emailUtente)) {
                $query = "UPDATE Posti SET libero = 'FALSE' WHERE idProiezione = '" . $idProiezione . "' AND posto = '" . $posto . "' LOCK IN SHARE MODE";
                $sender = $this->db->prepare($query);
                $sender->execute();
                $this->db->commit();
                FBiglietti::delete($idProiezione,"idProiezione",$posto,"posto");
                return true;
            }
            return false;
        } catch(PDOException $exception) {
            $this->db->rollBack();
            echo ("Errore nel Database: " . $exception->getMessage());
            return null;
        }
    }


}