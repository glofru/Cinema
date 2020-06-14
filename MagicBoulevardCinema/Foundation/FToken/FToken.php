<?php

/**
 * Classe che permette il salvataggio e il caricamento di oggetti EToken dal DB.
 * Class FToken
 * @author Lofrumento - Di Santo - Susanna
 * @package Foundation
 */
class FToken implements Foundation
{
    /**
     * Nome della classe.
     * @var string
     */
    private static string $className  = "FToken";

    /**
     * Nome della corrispondente tabella presente nel DB.
     * @var string
     */
    private static string $tableName  = "Token";

    /**
     * Insieme delle colonne presenti nella tabella nel DB che verrà sostituita in fase di binding.
     * @var string
     */
    private static string $valuesName = "(:value,:creationDate,:creationHour,:idUtente)";

    /**
     * Funzione che esegue il binding fra i parametri ed i reali valori da assegnare per salvare l'oggetto.
     * @param PDOStatement $sender
     * @param $token, oggetto dal quale si vogliono prelevare i valori.
     * @return mixed|void
     */
    public static function associate(PDOStatement $sender, $token){
        if ($token instanceof EToken) {
            $sender->bindValue(':value',        $token->getValue(),           PDO::PARAM_STR);
            $sender->bindValue(':creationDate', $token->getCreationdateDB(),  PDO::PARAM_STR);
            $sender->bindValue(':creationHour', $token->getCreationHour(),    PDO::PARAM_STR);
            $sender->bindValue(':idUtente',     $token->getUtente()->getId(), PDO::PARAM_STR);
        } else {
            die("Not a token!!");
        }
    }

    /**
     * Funzione che ritorna il nome della classe.
     * @return string
     */
    public static function getClassName(): string {
        return self::$className;
    }

    /**
     * Funzione che ritorna il nome della tabella presente nel DB.
     * @return string
     */
    public static function getTableName(): string {
        return self::$tableName;
    }

    /**
     * Funzione che ritorna i valori delle colonne della tabella per il binding.
     * @return string
     */
    public static function getValuesName(): string {
        return self::$valuesName;
    }

    /**
     * Funzione che permette di caricare un insieme di posti dal DB. Torna un EToken se questo esiste nel DB altrimenti null.
     * @param string $value, valore da usare per identificare l'oggetto.
     * @param string $row, colonna nella quale cercare il valore.
     * @return EToken|mixed|null, oggetto EToken o null.
     * @throws Exception
     */
    public static function load(string $value, string $row) {
        $db     = FDatabase::getInstance();

        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        $row    = $result[0];
        $value  = $row["value"];
        $creationDate = new DateTime($row["creationDate"] . "T" . $row["creationHour"]);

        $utente = FUtente::load($row["idUtente"], "id");

        return new EToken($value, $creationDate, $utente);
    }

    /**
     * Funzione che permette di aggiornare un oggetto Token nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indentificare l'oggetto.
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
     * @param $value, valore necessario ad indentificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @return bool, risultato dell'operazione.
     */
    public static function delete($value, $row): bool {
        $db = FDatabase::getInstance();

        return $db->deleteFromDB(self::getClassName(), $value, $row);
    }

    /**
     * Funzione che permette di salvare un Token sul DB.
     * @param EToken $token, token da salvare.
     */
    public static function save(EToken $token) {
        $db = FDatabase::getInstance();

        $db->saveToDB(self::getClassName(), $token);
    }
}