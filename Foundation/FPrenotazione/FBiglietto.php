<?php

/**
 * Classe che permette il salvataggio e il caricamento di oggetti EBiglietto dal DB.
 * Class FBiglietto
 * @author Lofrumento - Di Santo - Susanna
 * @package Foundation
 */
class FBiglietto implements FoundationDebole
{
    /**
     * Nome della classe.
     * @var string
     */
    private static string $className = "FBiglietto";

    /**
     * Nome della corrispondente tabella presente sul DB.
     * @var string
     */
    private static string $tableName = "Biglietto";

    /**
     * Insieme delle colonne presenti nella tabella sul DB che verrà sostituita in fase di binding.
     * @var string
     */
    private static string $valuesName = "(:idProiezione,:posto,:idUtente,:costo,:id)";

    /**
     * FBiglietto constructor.
     */
    public function __construct() {}

    /**
     * Funzione che esegue il binding fra i parametri ed i reali valori da assegnare per salvare l'oggetto.
     * @param PDOStatement $sender
     * @param $biglietto, oggetto dal quale si vogliono prelevare i valori.
     * @param null $obj2, , oggetto dal quale si vogliono prelevare i valori (NULL di default).
     * @return mixed|void
     */
    public static function associate(PDOStatement $sender, $biglietto, $obj2 = null) {
        if ($biglietto instanceof EBiglietto) {
            $sender->bindValue(':idProiezione', $biglietto->getProiezione()->getId(), PDO::PARAM_INT);
            $sender->bindValue(':posto', $biglietto->getPosto()->getId(), PDO::PARAM_STR);
            $sender->bindValue(':idUtente',$biglietto->getUtente()->getId(),PDO::PARAM_INT);
            $sender->bindValue(':costo',$biglietto->getCosto(),PDO::PARAM_STR);
            $sender->bindValue(':id',$biglietto->getId(),PDO::PARAM_STR);
        } else {
            die("Not a ticket!!");
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
     * Funzione che permette di salvare un giudizio sul DB.
     * @param EBiglietto $biglietto, biglietto da salvare.
     */
    public static function save(EBiglietto $biglietto) {
        $db = FDatabase::getInstance();
        $db->saveToDB(self::getClassName(), $biglietto);
    }

    /**
     * Funzione che permette di caricare un biglietto dal DB. Si appoggia alla funzione parseResult per ottenere come risultato un array di oggetti.
     * @param string $value, valore necessario ad indetificare l'oggetto.
     * @param string $row, colonna nella quale cercare il valore.
     * @return array, array di EBiglietto.
     */
    public static function load($value, $row) {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        return self::parseResult($result);
    }

    /**
     * Funzione che permette di caricare un giudizio dal DB passando due parametri in quanto entità debole. Si appoggia alla funzione parseResult per ottenere come risultato un array di oggetti.
     * @param $value, primo valore necessario ad indetificare l'oggetto.
     * @param $row, prima colonna nella quale cercare il valore.
     * @param $value2, secondo valore necessario ad indetificare l'oggetto.
     * @param $row2, secondo valore necessario ad indetificare l'oggetto.
     * @return EBiglietto, oggetto EBiglietto.
     */
    public static function loadDoppio($value, $row, $value2, $row2): EBiglietto {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDBDebole(self::getClassName(), $value, $row, $value2, $row2);
        if($result === null){
            return $result;
        }

        return self::parseResult($result)[0];
    }

    /**
     * Funzione che permette di aggiornare un oggetto biglietto nel DB. Ritorna l'esito dell'operazione.
     * @param $value, primo valore necessario ad indetificare l'oggetto.
     * @param $row, prima colonna nella quale cercare il valore.
     * @param $value2, secondo valore necessario ad indetificare l'oggetto.
     * @param $row2, secondo valore necessario ad indetificare l'oggetto.
     * @param $newvalue, valore che si vuole inserire.
     * @param $newrow, colonna nella quale inserire il nuovo valore.
     * @return bool, esito dell'operazione.
     */
    public static function update($value, $row, $value2, $row2, $newvalue, $newrow): bool {
        $db = FDatabase::getInstance();
        if($db->updateTheDBDebole(self::getClassName(), $value, $row, $value2, $row2, $newvalue, $newrow)){
            return true;
        }
        return false;
    }

    /**
     * Funzione che elimina un oggetto nel DB. Ritorna l'esito dell'operazione.
     * @param $value, primo valore necessario ad indetificare l'oggetto.
     * @param $row, prima colonna nella quale cercare il valore.
     * @param $value2, secondo valore necessario ad indetificare l'oggetto.
     * @param $row2, secondo valore necessario ad indetificare l'oggetto.
     * @return bool, esito dell'operazione.
     */
    public static function delete($value, $row, $value2, $row2): bool {
        $db = FDatabase::getInstance();
        if($db->deleteFromDBDebole(self::getClassName(), $value, $row, $value2, $row2)){
            return true;
        }
        return false;
    }

    /**
     * Funzione che, dato un array di righe ritornate dal DB, permette di ricostruire oggetti della classe EBiglietto ed inserirli un array da ritornare.
     * @param array $result, riga del database che si vuole 'parsare'.
     * @return array, arry di EBiglietto.
     */
    private static function parseResult(array $result): array
    {
        $return = [];
        if(sizeof($result) === 0) {
            return $return;
        }
        foreach ($result as $row) {
            //PROIEZIONE
            $id = $row["idProiezione"];
            $proiezione = FProiezione::load($id, "id");
            //POSTO
            $posto = $row["posto"];
            $posto = FPosto::loadDoppio($proiezione->getElencoProgrammazioni()[0]->getProiezioni()[0]->getId(), $posto);

            //UTENTE
            $utente = FUtente::load(intval($row["idUtente"]), "id");
            $costo = floatval($row["costo"]);

            //ID
            $id = $row["id"];
            array_push($return, new EBiglietto($proiezione->getElencoProgrammazioni()[0]->getProiezioni()[0], $posto, $utente, $costo, $id));
        }
        return $return;
    }
}