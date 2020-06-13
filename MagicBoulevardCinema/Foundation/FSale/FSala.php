<?php

/**
 * Classe che permette il salvataggio e il caricamento di oggetti ESalaFisica (oppure ESaleVirtuali) dal DB.
 * Class FSala
 * @author Lofrumento - Di Santo - Susanna
 * @package Foundation
 */
class FSala implements Foundation
{
    /**
     * Nome della classe.
     * @var string
     */
    private static string $className = "FSala";

    /**
     * Nome della corrispondente tabella presente sul DB.
     * @var string
     */
    private static string $tableName = "SalaFisica";

    /**
     * Insieme delle colonne presenti nella tabella sul DB che verrà sostituita in fase di binding.
     * @var string
     */
    private static string $valuesName = "(:nSala,:nFile,:nPostiFila,:disponibile)";

    /**
     * FSala constructor.
     */
    public function __construct() {}

    /**
     * Funzione che esegue il binding fra i parametri ed i reali valori da assegnare per salvare l'oggetto.
     * @param PDOStatement $sender
     * @param $salaFisica, oggetto dal quale si vogliono prelevare i valori.
     * @return mixed|void
     */
    public static function associate(PDOStatement $sender, $salaFisica){
        if ($salaFisica instanceof ESalaFisica) {
            $sender->bindValue(':nSala', $salaFisica->getNumeroSala(), PDO::PARAM_INT);
            $sender->bindValue(':nFile', $salaFisica->getNFile(), PDO::PARAM_INT);
            $sender->bindValue(':nPostiFila', $salaFisica->getNPostiFila(), PDO::PARAM_STR);
            $sender->bindValue(':disponibile', $salaFisica->isDisponibile(), PDO::PARAM_STR);
        } else {
            die("Not a phisical room!!");
        }
    }
//----------------- GETTER --------------------

    /**
     * Funzione che ritorna il nome della classe.
     * @return string
     */
    public static function getClassName() {
        return self::$className;
    }

    /**
     * Funzione che ritorna il nome della tabella presente sul DB.
     * @return string
     */
    public static function getTableName() {
        return self::$tableName;
    }

    /**
     * Funzione che ritorna i valori delle colonne della tabella per il binding.
     * @return string
     */
    public static function getValuesName() {
        return self::$valuesName;
    }

//------------- ALTRI METODI ----------------

    /**
     * Funzione che permette di salvare una SalaFisica sul DB.
     * @param ESalaFisica $salaFisica, SalaFisica da salvare.
     */
    public static function save(ESalaFisica $salaFisica) {
        $db = FDatabase::getInstance();
        $db->saveToDB(self::getClassName(),$salaFisica);
    }

    /**
     * Funzione che ritorna il numero di SaleFisiche attualemnte presente nel DB
     * @return int, numero di SaleFisiche presenti nel DB.
     */
    public static function nLoadAll(): int {
        $db = FDatabase::getInstance();
        $result = $db->loadAll(self::getClassName());

        return sizeof($result);
    }

    /**
     * Funzione che permette di caricare tutte le sale dal DB. Si appoggia alla funzione parseResult per ottenere come risultato un array di ESalaFisica.
     * @return array, array di ESalaFisica.
     */
    public static function loadAll(): array {
        $db = FDatabase::getInstance();
        $result = $db->loadAll(self::getClassName());
        return self::parseResult($result);
    }

    /**
     * Funzione che permette di caricare una sala dal DB. Si appoggia alla funzione parseResult per ottenere come risultato un array di ESalaFisica.
     * @param string $nSala, valore necessario ad indetificare l'oggetto.
     * @param string $row, colonna nella quale cercare il valore.
     * @return array, array di ESalaFisica.
     */
    public static function load (string $nSala, string $row): array {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), intval($nSala), $row);

        return self::parseResult($result);
    }

    /**
     * Funzione che permette di caricare una sala dal DB. Si appoggia alla funzione parseResult per ottenere come risultato un array di ESalaVirtuale.
     * @param string $nSala, valore necessario ad indetificare l'oggetto.
     * @param string $row, colonna nella quale cercare il valore.
     * @return array, array di ESalaVirtuale.
     */
    public static function loadVirtuale (string $nSala, string $row): array {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), intval($nSala), $row);

        return self::parseResult($result, false);
    }

    /**
     * Funzione che permette di aggiornare un oggetto Sala nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indetificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @param $newvalue, valore che si vuole inserire.
     * @param $newrow, colonna nella quale inserire il nuovo valore.
     * @return bool, risultato dell'operazione.
     */
    public static function update($value, $row, $newvalue, $newrow): bool {
        $db = FDatabase::getInstance();

        return $db->updateTheDB(self::getClassName(), $value, $row, $newvalue, $newrow);
    }

    /**
     * Funzione che elimina un oggetto nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indetificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @return bool, risultato dell'operazione.
     */
    public static function delete($value,$row): bool {
        $db = FDatabase::getInstance();

        return $db->deleteFromDB(self::getClassName(),$value,$row);
    }

    /**
     * Funzione che, dato un array di righe ritornate dal DB, permette di ricostruire oggetti della classe ESalaFisica o ESalaVirtuale.
     * @param array $result, righe del database che si vuole 'parsare'.
     * @param bool $fisica, booleano per identificare se si vuole restituito un oggetto ESalaFisica o ESalaVirtuale.
     * @return array, array di ESalaFisica o array di ESalaVirtuale.
     */
    private static function parseResult(array $result, bool $fisica = true): array {
        $return = [];

        foreach ($result as $row) {
            $nSala = $row["nSala"];
            $nFile = $row["nFile"];
            $nPostiFila = $row["nPostiFila"];
            $disponibile = boolval($row["disponibile"]);

            if ($fisica) {
                array_push($return, new ESalaFisica($nSala, $nFile, $nPostiFila, $disponibile));
            } else {
                array_push($return, new ESalaVirtuale($nSala, $nFile, $nPostiFila, $disponibile));
            }
        }

        return $return;
    }
}