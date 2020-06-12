<?php

/**
 * Classe che permette il salvataggio e il caricamento di oggetti EGiudizio dal DB.
 * Class FGiudizio
 * @author Lofrumento - Di Santo - Susanna
 * @package Foundation
 */
class FGiudizio
{
    /**
     * Nome della classe.
     * @var string
     */
    private static string $className = "FGiudizio";

    /**
     * Nome della corrispondente tabella presente sul DB.
     * @var string
     */
    private static string $tableName = "Giudizio";

    /**
     * Insieme delle colonne presenti nella tabella sul DB che verrà sostituita in fase di binding.
     * @var string
     */
    private static string $valuesName = "(:idUtente,:idFilm,:commento,:punteggio,:titolo,:datapubblicazione)";

    /**
     * FGiudizio constructor.
     */
    public function __construct() {}

    /**
     * Funzione che esegue il binding fra i parametri ed i reali valori da assegnare per salvare l'oggetto.
     * @param PDOStatement $sender
     * @param $giudizio, oggetto dal quale si vogliono prelevare i valori.
     * @return mixed|void
     */
    public function associate(PDOStatement $sender, $giudizio)
    {
        $sender->bindValue(':idUtente', $giudizio->getUtente()->getId(), PDO::PARAM_INT);
        $sender->bindValue(':idFilm', $giudizio->getFilm()->getId(), PDO::PARAM_INT);
        $sender->bindValue(':commento', $giudizio->getCommento(), PDO::PARAM_STR);
        $sender->bindValue(':punteggio', strval($giudizio->getPunteggio()), PDO::PARAM_STR);
        $sender->bindValue(':titolo', $giudizio->getTitle(), PDO::PARAM_STR);
        $sender->bindValue(':datapubblicazione', $giudizio->getDataPubblicazioneDB(), PDO::PARAM_STR);
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

    /**
     * Funzione che permette di salvare un giudizio sul DB.
     * @param EGiudizio $giudizio, giudizio da salvare.
     */
    public static function save(EGiudizio $giudizio) {
        $db = FDatabase::getInstance();
        $db->saveToDB(self::getClassName(),$giudizio);
    }


    /**
     * Funzione che permette di caricare un giudizio dal DB. Si appoggia alla funzione parseResult per ottenere come risultato un array di oggetti.
     * @param string $value, valore necessario ad indetificare l'oggetto.
     * @param string $row, colonna nella quale cercare il valore.
     * @return array, array di EGiudizio.
     */
    public static function load(string  $value, string $row): array
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $value, $row);
        if ($result == null || sizeof($result) == 0)
        {
            return [];
        }

        return self::parseResult($result);

    }

    /**
     * Funzione che permette di caricare un giudizio dal DB passando due parametri in quanto entità debole. Si appoggia alla funzione parseResult per ottenere come risultato un array di oggetti.
     * @param $value, primo valore necessario ad indetificare l'oggetto.
     * @param $row, prima colonna nella quale cercare il valore.
     * @param $value2, secondo valore necessario ad indetificare l'oggetto.
     * @param $row2, secondo valore necessario ad indetificare l'oggetto.
     * @return EGiudizio, oggetto EGiudizio.
     */
    public static function loadDoppio($value,$row,$value2,$row2): EGiudizio
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDBDebole(self::getClassName(),$value,$row,$value2,$row2);
        if($result === null)
        {
            return $result;
        }

        return self::parseResult($result)[0];
    }

    /**
     * Funzione che permette di aggiornare un oggetto giudizio nel DB. Ritorna l'esito dell'operazione.
     * @param $value, primo valore necessario ad indetificare l'oggetto.
     * @param $row, prima colonna nella quale cercare il valore.
     * @param $value2, secondo valore necessario ad indetificare l'oggetto.
     * @param $row2, secondo valore necessario ad indetificare l'oggetto.
     * @param $newvalue, valore che si vuole inserire.
     * @param $newrow, colonna nella quale inserire il nuovo valore.
     * @return bool, esito dell'operazione.
     */
    public static function update($value,$row,$value2,$row2,$newvalue,$newrow): bool
    {
        $db = FDatabase::getInstance();
        if($db->updateTheDBDebole(self::getClassName(),$value,$row,$value2,$row2,$newvalue,$newrow)){
            return true;
        }
        return false;
    }

    /**
     * Funzione che elimina un oggetto nel DB. Ritorna l'esito dell'operazione.
     * @param $value, primo valore necessario ad indetificare l'oggetto.
     * @param $row, prima colonna nella quale cercare il valore.
     * @param $value2, secondo valore necessario ad indetificare l'oggetto.
     * @param $row2, seconda colonna nella quale cercare il valore.
     * @return bool, esito dell'operazione.
     */
    public static function delete($value,$row,$value2,$row2): bool
    {
        $db = FDatabase::getInstance();
        if($db->deleteFromDBDebole(self::getClassName(),$value,$row,$value2,$row2)){
            return true;
        }
        return false;
    }

    /**
     * Funzione che, dato un array di righe ritornate dal DB, permette di ricostruire oggetti della classe EFilm ed inserirli un array da ritornare.
     * @param $result, riga del database che si vuole 'parsare'.
     * @return array, array di EGiudizio.
     */
    public static function parseResult($result): array {
        $return = [];
        foreach ($result as $row) {
            $idRegistrato = $row["idUtente"];
            $film = $row["idFilm"];
            $punteggio = floatval($row["punteggio"]);
            $commento = $row["commento"];
            $utente = FUtente::load($idRegistrato,"id");
            $film = FFilm::load($film,"id");
            $titolo = $row["titolo"];
            $data = DateTime::createfromFormat('Y-m-d', $row["datapubblicazione"]);
            array_push($return,new EGiudizio($commento, $punteggio, $film[0], $utente, $titolo, $data));
        }
        return $return;
    }

}