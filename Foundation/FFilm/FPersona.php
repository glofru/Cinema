<?php

/**
 * Classe che implementa i metodi necessari a poter salvare e caricare oggetti EPersona sul Database.
 * Class FPersona
 * @author Lofrumento - Di Santo - Susanna
 * @package Foundation
 */
class FPersona implements Foundation
{
    /**
     * Nome della classe.
     * @var string
     */
    private static string $className = "FPersona";

    /**
     * Nome della corrispondente tabella presente sul DB.
     * @var string
     */
    private static string $tableName = "Persona";

    /**
     * Insieme delle colonne presenti nella tabella sul DB che verrà sostituita in fase di binding.
     * @var string
     */
    private static string $valuesName = "(:id,:nome,:cognome,:imdbURL,:isAttore,:isRegista)";

    /**
     * FPersona constructor.
     */
    public function __construct() {}

    /**
     * Funzione che esegue il binding fra i parametri ed i reali valori da assegnare per salvare l'oggetto.
     * @param PDOStatement $sender
     * @param $persona, oggetto dal quale si vogliono prelevare i valori.
     * @return mixed|void
     */
    public static function associate(PDOStatement $sender, $persona) {
        if ($persona instanceof EPersona) {
            $sender->bindValue(':id', $persona->getId(), PDO::PARAM_INT);
            $sender->bindValue(':nome', $persona->getNome(), PDO::PARAM_STR);
            $sender->bindValue(':cognome', $persona->getCognome(), PDO::PARAM_STR);
            $sender->bindValue(':imdbURL', $persona->getImdbUrl(), PDO::PARAM_STR);
            $sender->bindValue(':isAttore', $persona->isAttore(), PDO::PARAM_BOOL);
            $sender->bindValue(':isRegista', $persona->isRegista(), PDO::PARAM_BOOL);
        } else {
            die("Not a person!!");
        }
    }

    /**
     * Funzione che ritorna il nome della classe.
     * @return string
     */
    public static function getClassName()
    {
        return self::$className;
    }

    /**
     * Funzione che ritorna il nome della tabella presente sul DB.
     * @return string
     */
    public static function getTableName()
    {
        return self::$tableName;
    }

    /**
     * Funzione che ritorna i valori delle colonne della tabella per il binding.
     * @return string
     */
    public static function getValuesName()
    {
        return self::$valuesName;
    }

    /**
     * Funzione che permette di salvare una persona sul DB.
     * @param EPersona $persona, persona da salvare.
     */
    public static function save(EPersona $persona)
    {
        $db = FDatabase::getInstance();
        $db->saveToDB(self::getClassName(), $persona);
    }

    /**
     * Funzione che permette di aggiorare un oggetto persona nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indetificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @param $newvalue, valore che si vuole inserire.
     * @param $newrow, colonna nella quale inserire il nuovo valore.
     * @return bool, risultato dell'operazione.
     */
    public static function update($value, $row, $newvalue, $newrow): bool
    {
        $db = FDatabase::getInstance();

        if($db->updateTheDB(self::getClassName(), $value, $row, $newvalue, $newrow))
        {
            return true;
        }

        return false;
    }

    /**
     * Funzione che elimina un oggetto nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indetificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @return bool, risultato dell'operazione.
     */
    public static function delete($value, $row): bool {
        $db = FDatabase::getInstance();
        if($db->deleteFromDB(self::getClassName(),$value,$row)){
            return true;
        }
        return false;
    }

    /**
     * Funzione che permette di caricare una persona dal DB. Ritorna un array contenente gli oggetti Persona reperiti.
     * @param string $value, valore necessario ad indetificare l'oggetto.
     * @param string $row, colonna nella quale cercare il valore.
     * @return array, array di EPersona.
     */
    public static function load (string $value, string $row): array
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        $return = [];

        foreach ($result as $row) {
            $id = $row["id"];
            $nome = $row["nome"];
            $cognome = $row["cognome"];
            $imdbUrl = $row["imdbURL"];
            $isAttore = $row["isAttore"];
            $isRegista = $row["isRegista"];
            $p = new EPersona($nome, $cognome, $imdbUrl, boolval($isAttore), boolval($isRegista));
            $p->setId($id);
            array_push($return, $p);
        }

        return $return;
    }
}