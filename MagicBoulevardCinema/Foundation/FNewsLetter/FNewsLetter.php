<?php

/**
 * Classe che permette il salvataggio e il caricamento di oggetti ENewsLetter dal DB.
 * Class FNewsLetter
 * @author Lofrumento - Di Santo - Susanna
 * @package Foundation
 */
class FNewsLetter
{
    /**
     * Nome della classe.
     * @var string
     */
    private static string $className  = "FNewsLetter";

    /**
     * Nome della corrispondente tabella presente sul DB.
     * @var string
     */
    private static string $tableName  = "NewsLetter";

    /**
     * Insieme delle colonne presenti nella tabella sul DB che verrà sostituita in fase di binding.
     * @var string
     */
    private static string $valuesName = "(:idUtente,:preferenze)";

    /**
     * FNewsLetter constructor.
     */
    public function __construct() {}

    /**
     * Funzione che esegue il binding fra i parametri ed i reali valori da assegnare per salvare l'oggetto.
     * @param PDOStatement $sender
     * @param ERegistrato $utente, oggetto dal quale si vogliono prelevare i valori.
     * @param string $preferenze
     */
    public static function associate(PDOStatement $sender, ERegistrato $utente, string $preferenze) {
        $sender->bindValue(':idUtente',   $utente->getId(), PDO::PARAM_INT);
        $sender->bindValue(':preferenze', $preferenze,      PDO::PARAM_STR);
    }

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

    /**
     * Funzione che permette di salvare un utente con le relative preferenze sul DB.
     * @param EUtente $utente, utente da salvare.
     * @param $preferenze, preferenze dell'utente da salvare.
     */
    public static function save(EUtente $utente, $preferenze) {
        $db = FDatabase::getInstance();

        $db->saveToDBNS($utente, $preferenze);
    }

    /**
     * Funzione che ritorna le preferenze di un utente.
     * @param $utente, utente del quale si vogliono recuperare le preferenze.
     * @return string, preferenze dell'utente.
     */
    public static function load($utente)  {
        $result = FDatabase::getInstance()->loadFromDB(self::getClassName(), $utente, "idUtente");

        return $result[0]["preferenze"];
    }

    /**
     * Funzione che ritorna un oggetto ENewsLetter con tutte le preferenze degli utenti. Si appoggia alla funzione parseResult per ottenere come risultato un oggetto ENewsLetter.
     * @return ENewsLetter, oggetto ENewsLetter.
     */
    public static function loadAll() {
        $db = FDatabase::getInstance();

        $result = $db->loadAll(self::getClassName());

        if($result === null){
            return new ENewsLetter();
        }

        return self::parseResult($result);
    }

    /**
     * Funzione che permette di aggiornare un utente nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indetificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @param $newvalue, valore che si vuole inserire.
     * @param $newrow, colonna nella quale inserire il nuovo valore.
     * @return bool, esito dell'operazione.
     */
    public static function update($value, $row, $newvalue, $newrow): bool {
        $db = FDatabase::getInstance();

        return $db->updateTheDB(self::getClassName(), $value, $row, $newvalue, $newrow);
    }

    /**
     * Funzione che elimina un oggetto nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indetificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @return bool, esito dell'operazione.
     */
    public static function delete($value, $row): bool {
        $db = FDatabase::getInstance();

        return $db->deleteFromDB(self::getClassName(), $value, $row);
    }

    /**
     * Funzione che, dato un array di righe ritornate dal DB, permette di ricostruire un oggetto della classe ENewsLetter.
     * @param $result, riga del database che si vuole 'parsare'.
     * @return ENewsLetter, oggetto ENewsLetter.
     */
    private static function parseResult($result): ENewsLetter {
        $ns = new ENewsLetter();

        foreach ($result as $utente) {
            $whois = FUtente::load($utente["idUtente"], "id");
            $ns->addUtenteEPreferenzaFromRaw($whois, $utente["preferenze"]);
        }

        return $ns;
    }

    /**
     * Funzione che permette di sapere se un utente è iscritto alla newsletter.
     * @param EUtente $utente, utente da cercare.
     * @return bool, se l'utente è iscritto alla newsletter.
     */
    public static function isASub(EUtente $utente): bool {
        $db = FDatabase::getInstance();

        $result = $db->loadFromDB(self::getClassName(), $utente->getId(), "idUtente");

        return sizeof($result) !== 0;
    }

}