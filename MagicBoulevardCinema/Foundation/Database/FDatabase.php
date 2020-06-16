<?php

require_once "configDB.conf.php";

/**
 * Classe che si occupa di connettersi al DB, via PDO, ed eseguire delle query da noi confezionate per eseguire tutte le operazioni necessarie al fine di garantire il recupero e la persistenza di oggetti sul DB. Gestita come Singleton.
 * @author Lofrumento - Di Santo - Susanna
 * @package Foundation
 */
class FDatabase
{
    /**
     * Istanza della classe.
     * @var FDatabase
     */
    private static $instance;

    /**
     * Oggetto che gestisce la connessione al DB.
     * @var PDO
     */
    private PDO $db;

    /**
     * FDatabase constructor.
     */
    private function __construct() {
        $dbname   = $GLOBALS["dbname"];
        $username = $GLOBALS["username"];
        $password = $GLOBALS["password"];

        try {
            $this->db = new PDO("mysql:dbname=" . $dbname . "; host=localhost; charset=utf8;", $username, $password);
        } catch (PDOException $exception) {
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
     * Funzione che permette di salvare un oggetto nel DB. Ritorna l'id dell'oggetto inserito oppure mostra la schemata di errore in caso di problemi con il DB.
     * @param $class
     * @param $values
     * @return mixed
     */
    public function saveToDB($class, $values){
        try {
            $this->db->beginTransaction();

            $query  = "INSERT INTO " . $class::getTableName() . " VALUES " . $class::getValuesName();
            $sender = $this->db->prepare($query);
            $class::associate($sender, $values);
            $sender->execute();

            $id     = $this->db->lastInsertId();
            $this->db->commit();

            return $id;
        } catch (PDOException $exception) {
            $this->error();
        }

        return null;
    }

    /**
     * Funzione che permette di salvare nel DB le preferenze di un utente che si iscrive alla Newsletter. Ritorna true in caso di successo o mostra la schemata di errore altrimenti.
     * @param $utente
     * @param $preferenze
     * @return mixed
     */
    public function saveToDBNS($utente, $preferenze) {
        try {
            $this->db->beginTransaction();

            $query  = "INSERT INTO " . FNewsLetter::getTableName() . " VALUES " . FNewsLetter::getValuesName();
            $sender = $this->db->prepare($query);
            FNewsLetter::associate($sender, $utente, $preferenze);
            $sender->execute();

            $this->db->commit();

            return true;
        } catch (PDOException $exception) {
            $this->error();
        }

        return null;
    }

    /**
     * Funzione che permette, atomicamente, di salvare nel DB una nuova proieizone ed al contempo istanziare nella tabella dei Posti tutti i sedili relativi alla proiezione. Ritorna l'id dell'oggetto aggiunto nel DB o la schemata di errore.
     * @param EProiezione $proiezione
     * @return mixed
     */
    public function saveToDBProiezioneEPosti(EProiezione $proiezione)
    {
        $posti = $proiezione->getSala()->getPosti();

        try {
            $this->db->beginTransaction();

            $query  = "INSERT INTO " . FProiezione::getTableName() . " VALUES " . FProiezione::getValuesName() . ";";
            $sender = $this->db->prepare($query);
            FProiezione::associate($sender, $proiezione);

            $sender->execute();

            $id     = $this->db->lastInsertId();
            $proiezione->setId($id);

            foreach ($posti as $file) {
                foreach ($file as $item) {
                    $query = "INSERT INTO " . FPosto::getTableName() . " VALUES " . FPosto::getValuesName();
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

        return null;
    }

    /**
     * Funzione che permette di salvare un'entità debole. Ritorna l'id dell'oggetto inserito oppure mostra la schemata di errore in caso di problemi con il DB.
     * @param $class
     * @param $entity1
     * @param $entity2
     * @return mixed
     */
    public function saveToDBDebole($class, $entity1, $entity2) {
        try {
            $this->db->beginTransaction();

            $query  = "INSERT INTO " . $class::getTableName() . " VALUES " . $class::getValuesName();
            $sender = $this->db->prepare($query);
            $class::associate($sender, $entity1, $entity2);

            $sender->execute();

            $id     = $this->db->lastInsertId();

            $this->db->commit();

            return $id;
        } catch (PDOException $exception) {
            $this->error();
        }

        return null;
    }

    /**
     * Funzione che permette di caricare oggetti dal DB. Ritorna un insieme di righe dal DB, corrispondenti alla ricerca, oppure una schemata di errore in caso di problemi con il DB.
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
        } catch (PDOException $exception) {
            $this->error(false);
        }
    }

    /**
     * Funzione che permette di caricare un oggetto dal Db se l'entità è debole. Ritorna un array con le righe corrispondenti alla ricerca o una schermata di errore.
     * @param $class
     * @param $value
     * @param string $row
     * @param $value2
     * @param $row2
     * @return array
     */
    public function loadFromDBDebole($class, $value, string $row, $value2, $row2) {
        try {
            $query = "SELECT * FROM " . $class::getTableName() . " WHERE " . $row . " = '" . $value. "' AND " . $row2 . " = '" . $value2 . "';";

            return $this->executeQuery($query);
        } catch (PDOException $exception) {
            $this->error(false);
        }
    }

    /**
     * Funzione che permette di reperire dal DB oggetti che hanno una data compresa nell'intervallo inserito. Ritorna un array con le righe corrispondenti o una schermata di errore.
     * @param $class
     * @param string $datainizio
     * @param string $datafine
     * @param string $row
     * @return array
     */
    public function loadBetween($class, string $datainizio, string $datafine, string $row) {
        try {
            $query = "SELECT * FROM " . $class::getTableName() . " WHERE " . $row . " BETWEEN '" . $datainizio . "' AND '" . $datafine . "';";

            return $this->executeQuery($query);
        } catch(Exception $exception) {
            $this->error(false);
        }
    }

    /**
     * Funzione che permette di reperire dal DB oggetti con un valore (value) simile a quelli presenti nella colonna row. Ritorna un array con le righe corrispondenti o una schermata di errore.
     * @param $class
     * @param string $value
     * @param string $row
     * @return array
     */
    public function loadLike($class, string $value, string $row) {
        try {
            $query = "SELECT * FROM " . $class::getTableName() . " WHERE " . $row . " LIKE '%" . $value . "%';";

            return $this->executeQuery($query);
        } catch(Exception $exception) {
            $this->error(false);
        }
    }

    /**
     * Funzione che reperisce tutte le righe dal DB di una determnitata tabella. Ritorna un array con tutte le righe o una schermata di errore.
     * @param $class
     * @return array
     */
    public function loadAll($class) {
        try {
            $query = "SELECT * FROM " . $class::getTableName() . ";";

            return $this->executeQuery($query);
        } catch (PDOException $exception) {
            $this->error(false);
        }
    }

    /**
     * Funzione che permette di caricare dal DB oggetti che hanno una data successiva a quella passata come parametro. Ritorna un insieme di righe oppure una schermata di errore.
     * @param $class
     * @param DateTime $time
     * @return array
     */
    public function loadByDate($class, DateTime $time) {
        try {
            $query = "SELECT * FROM " . $class::getTableName() . " WHERE data >= " . $time->format("Y-m-d") . ";";

            return $this->executeQuery($query);
        } catch (PDOException $exception) {
            $this->error(false);
        }
    }

    /**
     * Funzione di supporto al controllo sovrapposizione di FProiezione.
     * @param EProiezione $proiezione
     * @return array
     */
    public function isSovrappostaProiezione(EProiezione $proiezione) {
        try {
            $query = "SELECT * FROM Proiezione WHERE numerosala = '{$proiezione->getSala()->getNumeroSala()}' AND `data` = '{$proiezione->getDataSQL()}';";

            return $this->executeQuery($query);
        } catch(Exception $exception) {
            $this->error(false);
        }
    }

    /**
     * Funzione che permette di eliminare un oggetto dal DB. Ritorna l'esito dell'operazione od una schermata di errore
     * @param $class
     * @param $value
     * @param $row
     * @return bool
     */
    public function deleteFromDB($class, $value, string $row): bool {
        try{
            $this->db->beginTransaction();

            $query  = "DELETE FROM " . $class::getTableName() . " WHERE " . $row . " = '" . $value . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();

            $this->db->commit();

            return true;
        } catch(PDOException $exception) {
            $this->error();
        }

        return false;
    }

    /**
     * Funzione che permette di eliminare un oggetto dal Db se l'oggetto è un'entità debole. Ritorna l'esito dell'operazione o una schermata di errore.
     * @param $class
     * @param $value
     * @param $row
     * @param $value2
     * @param $row2
     * @return bool
     */
    public function deleteFromDBDebole($class, $value, $row, $value2, $row2): bool {
        try{
            $this->db->beginTransaction();

            $query  = "DELETE FROM " . $class::getTableName() . " WHERE " . $row . "='" . $value . "' AND ". $row2 . "= '" . $value2 . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();

            $this->db->commit();

            return true;
        } catch(PDOException $exception) {
            $this->error();
        }

        return false;
    }

    /**
     * Funzione che permette di aggiornare un oggetto presente nella base dati. Ritorna l'esito dell'operazione oppure una schermata di errore.
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

            if($class === "FMedia" && $row === "idUtente") {
                $query = "UPDATE " . $class::getTableName("EMediaUtente")   . " SET " . $newRow . "='" . $newValue . "' WHERE " . $row . "='" . $value . "';";
            } else if ($class === "FMedia" && $row === "idFilm"){
                $query = "UPDATE " . $class::getTableName("EMediaLocandina")     . " SET " . $newRow . "='" . $newValue . "' WHERE " . $row . "='" . $value . "';";
            } else {
                $query = "UPDATE " . $class::getTableName()                 . " SET " . $newRow . "='" . $newValue . "' WHERE " . $row . "='" . $value . "';";
            }

            $sender = $this->db->prepare($query);
            $sender->execute();

            $this->db->commit();

            return true;
        } catch(PDOException $exception) {
            $this->error();
        }

        return false;
    }

    /**
     * Funzione che permette di aggiornare un oggetto nel DB se è una entità debole. Ritorna l'esito dell'operazione o una schermata di errore.
     * @param $class
     * @param $value
     * @param $row
     * @param $value2
     * @param $row2
     * @param $newRow
     * @param $newValue
     * @return bool
     */
    public function updateTheDBDebole($class, $value, $row, $value2, $row2, $newRow, $newValue): bool {
        try {
            $this->db->beginTransaction();

            $query  = "UPDATE " . $class::getTableName() . " SET " . $newRow . "='" . $newValue . "' WHERE " . $row . "= '" . $value. "' AND " . $row2 . "= '" . $value2 . "';";
            $sender = $this->db->prepare($query);
            $sender->execute();

            $this->db->commit();

            return true;
        } catch(PDOException $exception) {
            $this->error();
        }

        return false;
    }

    /**
     * Funzione che permette, dato un insieme di biglietti, di salvare questi ultimi nel DB ed al contempo di occupare i relativi posti. Ritorna null se non esiste il posto inserito, false se uno dei posti è stato già occupato, true se l'operazione è andata a buon fine, altrimenti una schermata di errore.
     * @param array $biglietti
     * @return bool|null
     */
    public function occupaPosti(array $biglietti) {
        try {
            $this->db->beginTransaction();

            foreach ($biglietti as $item) {
                $query  = "SELECT * FROM " . "Posti" . " WHERE " . "idProiezione = '" . $item->getProiezione()->getId() . "' AND " . "posizione = '" . $item->getPosto()->getId() . "' FOR UPDATE;";
                $sender = $this->db->prepare($query);
                $sender->execute();

                $posto  = $sender->fetch(PDO::FETCH_ASSOC);

                if($posto == null) { //Non esiste il posto
                    $this->db->rollBack();
                    return null;
                }

                if(boolval($posto["occupato"])) { //Il posto è occupato
                    $this->db->rollBack();
                    return false;
                }

                //i settaggi di occupazione e instaurazione di biglietto insieme per consistenza ,
                // biglietti e posti insieme non separati infatti il commit alla fine (445)

                $query  = "UPDATE Posti SET occupato = '1' WHERE idProiezione = '" . $item->getProiezione()->getId() . "' AND posizione = '" . $item->getPosto()->getId() . "';";
                $sender = $this->db->prepare($query);
                $sender->execute();

                $query  = "INSERT INTO " . FBiglietto::getTableName() . " VALUES " . FBiglietto::getValuesName();
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

    /**
     * Funzione che permette di salvare nel Database una immagine. Ritorna l'id dell'oggetto inserito oppure una schermata di errore.
     * @param $class
     * @param EMedia $media
     * @return mixed
     */
    public function storeMedia($class, EMedia $media) {
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
    }

    /**
     * Funzione che permette di caricare dal DB un oggetto seguendo alcuni valori di filtro. Ritorna un array contenente i valori corrispondenti.
     * @param $class
     * @param $genere
     * @param float $votoInizio
     * @param float $votoFine
     * @param string $dataInizio
     * @param string $dataFine
     * @return array
     */
    public function loadByFilter($class, $genere, float $votoInizio, float $votoFine, string $dataInizio, string $dataFine) {
        $query = "SELECT * FROM {$class::getTableName()} WHERE genere = '{$genere}' AND (dataRilascio >= '{$dataInizio}' AND dataRilascio <= '{$dataFine}') AND ((votoCritica >= {$votoInizio} AND votoCritica <= {$votoFine}) OR votoCritica = 0);";

        return $this->executeQuery($query);
    }

    /**
     * Funzione di utilità che esegue la query, passata come parametro, sul DB. Ritorna un array con il risultato della query.
     * @param $query
     * @return array
     */
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

    /**
     * Funzione che viene chiamata nel caso di errore nel momento in cui si esegua un'operazione sul DB. Ne mantiene la consistenza in caso di inserimenti attraverso il rollback e mostra una schermata di errore per segnalare l'accaduto.
     * @param bool $rollBack
     * @throws SmartyException
     */
    private function error($rollBack = true) {
        if ($rollBack) {
            $this->db->rollBack();
        }

        VError::error(1);
        die;
    }

}