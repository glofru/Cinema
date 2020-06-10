<?php

require_once "configDB.conf.php";

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
        }
    }

    /**
     * @return FDatabase
     */
    public static function getInstance(): FDatabase{
        if (self::$instance == null) {
            self::$instance = new FDatabase();
        }

        return self::$instance;
    }

    /**
     * @param $class
     * @param $values
     * @return
     */
    public function saveToDB($class, $values){
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
            $this->error();
        }

        return null;
    }

    public function saveToDBNS($utente, $preferenze) {
        try {
            $this->db->beginTransaction();
            $query = "INSERT INTO " . FNewsLetter::getTableName() . " VALUES " . FNewsLetter::getValuesName();
            $sender = $this->db->prepare($query);
            FNewsLetter::associate($sender, $utente, $preferenze);
            $sender->execute();
            $this->db->commit();
        } catch (PDOException $exception) {
            $this->error();
        }

        return null;
    }

    public function saveToDBProiezioneEPosti(EProiezione $proiezione)
    {
        $posti = $proiezione->getSala()->getPosti();

        if (!isset($posti)) {
            return null;
        }

        try {
            $this->db->beginTransaction();
            $query = "INSERT INTO" . FProiezione::getTableName() . "VALUES " . FProiezione::getValuesName();
            $sender = $this->db->prepare($query);
            FProiezione::associate($sender, $proiezione);

            $sender->execute();

            $id = $this->db->lastInsertId();

            foreach ($posti as $file) {
                foreach ($file as $item) {
                    $query = "INSERT INTO" . FPosto::getTableName() . "VALUES " . FPosto::getValuesName();
                    $sender = $this->db->prepare($query);
                    FPosto::associate($sender, $proiezione, $item);

                    $sender->execute();
                }
            }

            $this->db->commit();

            return $id;
        } catch (Exception $exception) {
            $this->error();
        }
    }

    public function saveToDBDebole($class, EProiezione $proiezione, EPosto $posto) {
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
            $this->error();
        }

        return null;
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

            return $this->executeQuery($query);
        }
        catch (PDOException $exception) {
            $this->error(false);
        }

        return null;
    }

    public function loadFromDBDebole($class, $value, string $row, $value2, $row2) {
        try {
            $query = "SELECT * FROM " . $class::getTableName() . " WHERE " . $row . " = '" . $value. "' AND " . $row2 . " = '" . $value2 . "';";

            return $this->executeQuery($query);
        }
        catch (PDOException $exception) {
            $this->error(false);
        }

        return null;
    }

    public function loadBetween($class, string $datainizio, string $datafine, string $row) {
        try {
            $query = "SELECT * FROM " . $class::getTableName() . " WHERE " . $row . " BETWEEN '" . $datainizio . "' AND '" . $datafine . "';";

            return $this->executeQuery($query);
        }
        catch(Exception $exception) {
            $this->error(false);
        }

        return null;
    }

    public function loadLike($class, string $value, string $row) {
        try {
            $query = "SELECT * FROM " . $class::getTableName() . " WHERE " . $row . " LIKE '%" . $value . "%';";

            return $this->executeQuery($query);
        } catch(Exception $exception) {
            $this->error(false);
        }

        return null;
    }

    public function loadAll($class) {
        try {
            $query = "SELECT * FROM " . $class::getTableName() . ";";

            return $this->executeQuery($query);
        }
        catch (PDOException $exception) {
            $this->error(false);
        }

        return null;
    }

    public function checkDisponibilita(int $nsala, string $data, string $oraInizioNuovoFilm) {
        try {
            $query = "SELECT * FROM Proiezione WHERE numerosala = '" . strval($nsala) . "' AND data = '" . $data . "';";

            $proiezioni = $this->executeQuery($query);

            $output = [];

            for($i = 0; $i < sizeof($proiezioni); $i++) {
                $film = FFilm::load($proiezioni[$i]["idFilm"],"id");

                $durata = new DateInterval($film[0]->getDurataDB());
                $oraFilmPresente = $proiezioni[$i]["ora"];
                $oraFine = DateTime::createFromFormat("H:i:s",$oraFilmPresente)->add($durata);

                //TODO: Ale porco mondo
                if((strtotime($oraInizioNuovoFilm) - strtotime($oraFilmPresente) >= 0) && (strtotime($oraInizioNuovoFilm) - strtotime($oraInizioNuovoFilm)) >= 0) {
                    $salaVirtuale = FSala::loadVirtuale(strval($nsala), "nSala")[0];
                    $data = DateTime::createFromFormat("Y-m-d",$proiezioni[$i]["data"]);
                    $proiezione = new EProiezione($film[0], $salaVirtuale, $data);

                    array_push($output, $proiezione);
                }
            }
            return $output;
        }
        catch(Exception $exception) {
            $this->error(false);
        }

        return null;
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

            return true;
        }
        catch(PDOException $exception) {
            $this->error();
        }

        return false;
    }

    public function deleteFromDBDebole($class, $value, $row, $value2, $row2): bool {
        try{
            $this->db->beginTransaction();

            $query = "DELETE FROM " . $class::getTableName() . " WHERE " . $row . "='" . $value . "' AND ". $row2 . "= '" . $value2 . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();

            $this->db->commit();

            return true;
        }
        catch(PDOException $exception) {
            $this->error();
        }

        return false;
    }

    /**
     * @param $class
     * @param $value
     * @param $row
     * @param $newRow
     * @param $newValue
     * @return bool
     */
    public function updateTheDB($class, $value, string $row, $newValue, string $newRow): bool {
        try {
            $this->db->beginTransaction();

            $query = "UPDATE " . $class::getTableName() . " SET " . $newRow . "='" . $newValue . "' WHERE " . $row . "='" . $value . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();

            $this->db->commit();

            return true;
        }
        catch(PDOException $exception) {
            $this->error();
        }

        return false;
    }

    public function updateTheDBDebole($class, $value, $row, $value2, $row2, string $newRow, $newValue): bool {
        try {
            $this->db->beginTransaction();
            $query = "UPDATE " . $class::getTableName() . " SET " . $newRow . "='" . $newValue . "' WHERE " . $row . "= '" . $value. "' AND " . $row2 . "= '" . $value2 . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();
            $this->db->commit();

            return true;
        }
        catch(PDOException $exception) {
            $this->error();
        }

        return false;
    }

    public function occupaPosti(array $biglietti) {
        try {
            $this->db->beginTransaction();

            foreach ($biglietti as $item) {
                $query = "SELECT * FROM " . "Posti" . " WHERE " . "idProiezione = '" . $item->getProiezione()->getId() . "' AND " . "posizione = '" . $item->getPosto()->getId() . "' FOR UPDATE;";
                $sender = $this->db->prepare($query);
                $sender->execute();

                $posto = $sender->fetch(PDO::FETCH_ASSOC);

                if($posto == null) { //Non esiste il posto
                    $this->db->rollBack();
                    return null;
                }

                if(boolval($posto["occupato"])) { //Il posto è occupato
                    $this->db->rollBack();
                    return false;
                }

                $query = "UPDATE Posti SET occupato = '1' WHERE idProiezione = '" . $item->getProiezione()->getId() . "' AND posizione = '" . $item->getPosto()->getId() . "';";
                $sender = $this->db->prepare($query);
                $sender->execute();

                $query = "INSERT INTO " . FBiglietto::getTableName() . " VALUES " . FBiglietto::getValuesName();
                $sender = $this->db->prepare($query);

                FBiglietto::associate($sender, $item);

                $sender->execute();
            }

            $this->db->commit();
        } catch(PDOException $exception) {
            $this->error();
        }
        return true;
    }

    /*public function liberaPosto($idProiezione, $posto, $emailUtente) {
        try {
            $this->db->beginTransaction();
            $query = "SELECT * FROM " . "Posti" . " WHERE " . "idProiezione" . "= '" . $idProiezione. "' AND " . "posizione" . "= '" . $posto . "' LOCK IN SHARE MODE;";
            $sender = $this->db->prepare($query);
            $sender->execute();

            $acquisto = $sender->fetch(PDO::FETCH_ASSOC);
            $islibero = $acquisto["libero"];
            $biglietto = FBiglietto::loadDoppio($idProiezione, "idProiezione", $posto, "posto");

            if(!boolval($islibero) && ($biglietto->getUtente()->getEmail() === $emailUtente)) {
                $query = "UPDATE Posti SET libero = '1' WHERE idProiezione = '" . $idProiezione . "' AND posizione = '" . $posto . "';";
                $sender = $this->db->prepare($query);
                $sender->execute();
                $this->db->commit();

                FBiglietto::delete($idProiezione,"idProiezione",$posto,"posto");
                return true;
            }
        } catch(PDOException $exception) {
            $this->error();
        }

        return false;
    }*/

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
        } catch(PDOException $exception) {
            $this->error();
        }

        return null;
    }

    public function loadByFilter($class, $genere, float $votoInizio, float $votoFine, string $dataInizio, string $dataFine) {
        $query = "SELECT * FROM {$class::getTableName()} WHERE genere = '{$genere}' AND (dataRilascio >= '{$dataInizio}' AND dataRilascio <= '{$dataFine}') AND ((votoCritica >= {$votoInizio} AND votoCritica <= {$votoFine}) OR votoCritica = 0);";

        return $this->executeQuery($query);
    }

    private function executeQuery($query) {
        $sender = $this->db->prepare($query);
        $sender->execute();

        $returnedRows = $sender->rowCount();

        $return = [];

        if($returnedRows == 0){
            return [];
        } elseif ($returnedRows == 1) {
            array_push($return, $sender->fetch(PDO::FETCH_ASSOC));
        } else {
            $sender->setFetchMode(PDO::FETCH_ASSOC);

            while($elem = $sender->fetch()) {
                $return[] = $elem;
            }
        }

        return $return;
    }

    private function error($rollBack = true) {
        if ($rollBack) {
            $this->db->rollBack();
        }

        VError::error(1);
        die;
    }

}