<?php

/**
 * Classe che permette il salvataggio e il caricamento di oggetti EMedia (EMediaLocandina oppure EMediaUtente) dal DB.
 * Class FMedia
 * @author Lofrumento - Di Santo - Susanna
 * @package Foundation
 */
class FMedia implements Foundation
{
    /**
     * Nome della classe.
     * @var string
     */
    private static string $className = "FMedia";

    /**
     * Nome della corrispondente tabella presente sul DB se ci si riferisce ad una immagine del profilo.
     * @var string
     */
    private static string $tableNameUtente = "MediaUtente";

    /**
     * Nome della corrispondente tabella presente sul DB se ci si riferisce ad una locandina di un film.
     * @var string
     */
    private static string $tableNameLocandina = "MediaLocandina";

    /**
     * Insieme delle colonne presenti nella tabella sul DB che verrà sostituita in fase di binding se l'oggetto è una immagine del profilo.
     * @var string
     */
    private static string $valuesNameUtente = "(:id,:fileName,:mimeType,:idUtente,:date,:immagine)";

    /**
     * Insieme delle colonne presenti nella tabella sul DB che verrà sostituita in fase di binding se l'oggetto è una locandina.
     * @var string
     */
    private static string $valuesNameLocandina = "(:id,:fileName,:mimeType,:idFilm,:date,:immagine)";

    /**
     * FMedia constructor.
     */
    public function __construct() {}

    /**
     * Funzione che esegue il binding fra i parametri ed i reali valori da assegnare per salvare l'oggetto.
     * @param PDOStatement $sender
     * @param $media, oggetto dal quale si vogliono prelevare i valori.
     * @return mixed|void
     */
    public static function associate(PDOStatement $sender, $media)
    {
        if ($media instanceof EMedia) {
            $sender->bindValue(":id", NULL, PDO::PARAM_INT);
            $sender->bindValue(":fileName", $media->getFileName(), PDO::PARAM_STR);
            $sender->bindValue(":mimeType", $media->getMimeType(), PDO::PARAM_STR);
            $sender->bindValue(":date",$media->getDateStringSQL(),PDO::PARAM_STR);

            if ($media instanceof EMediaUtente)
            {
                $sender->bindValue(":idUtente", $media->getUtente()->getId(), PDO::PARAM_STR);
            }
            else if ($media instanceof EMediaLocandina)
            {
                $sender->bindValue(":idFilm", $media->getFilm()->getId(), PDO::PARAM_STR);
            }

            $sender->bindValue(':immagine', $media->getImmagine(), PDO::PARAM_LOB);

        } else {
            die("Not a media!!");
        }
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
    public static function getTableName(string $media) {
       if ($media == "EMediaUtente") return self::$tableNameUtente;
       else return self::$tableNameLocandina;
    }

    /**
     * Funzione che ritorna i valori delle colonne della tabella per il binding.
     * @return string
     */
    public static function getValuesName(EMedia $media) {
        if ($media instanceof EMediaUtente) return self::$valuesNameUtente;
        else if ($media instanceof EMediaLocandina) return self::$valuesNameLocandina;
    }

    /**
     * Funzione che permette di salvare una immagine sul DB.
     * @param EMedia $media, immagine da salvare.
     */
    public static function save(EMedia $media) {
        $db = FDatabase::getInstance();
        $id = $db->storeMedia(static::getClassName(), $media);
        $media->setId($id);
    }

    /**
     * Funzione che elimina un oggetto nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indetificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @return bool, esito dell'operazione.
     */
    public static function delete($value, $row): bool {
        $db = FDatabase::getInstance();
        if($db->deleteFromDB(self::getClassName(),$value,$row)){
            return true;
        }
        return false;
    }

    /**
     * Funzione che permette di aggiorare un oggetto giudizio nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indetificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @param $newvalue, valore che si vuole inserire.
     * @param $newrow, colonna nella quale inserire il nuovo valore.
     * @return bool, esito dell'operazione.
     */
    public static function update($value,$row,$newvalue,$newrow): bool {
        $db = FDatabase::getInstance();
        if($db->updateTheDB(self::getClassName(), $value, $row, $newvalue, $newrow))
        {
            return true;
        }
        return false;
    }

    /**
     * Funzione che sulla base della tabella richiamata ritorna un oggetto immagine locandina o immagine del profilo di un utente. Se l'utente non ha una immagine gli viene temporaneamente assegnata l'immagine di default.
     * @param string $value, valore necessario ad indetificare l'oggetto.
     * @param string $row, colonna nella quale cercare il valore.
     * @return EMedia|EMediaLocandina|EMediaUtente|mixed, oggetto EMedia.
     */
    public static function load (string $value, string $row) {
        $db = FDatabase::getInstance();
        $media = $row == "idFilm" ? "EMediaLocandina" : "EMediaUtente";
        $result = $db->loadFromDB(self::getClassName(), $value, $row, $media);

        if($result == null) {
            return new EMedia("","",new DateTime('now'),"");
        }

        $row = $result[0];
        $fileName = $row["fileName"];
        $mimeType = $row["mimeType"];
        $immagine = strlen($row["immagine"])>0 ? $row["immagine"] : '../../Smarty/img/user.png' ;
        $date = $row["date"];
        $date = DateTime::createFromFormat('Y-m-d',$date);

        if (array_key_exists("idUtente", $row))
        {
            $idUtente = $row["idUtente"];
            $utente = FUtente::load($idUtente,"id");
            return new EMediaUtente($fileName, $mimeType, $date, $immagine,$utente);
        }
        else if (array_key_exists("idFilm", $row))
        {
            $idFilm = $row["idFilm"];
            $film = FFilm::load($idFilm,'id')[0];
            return new EMediaLocandina($fileName, $mimeType, $date, $immagine, $film);
        }
    }
}
