<?php


class FMedia implements Foundation
{
    private static string $className = "FMedia";

    private static string $tableNameUtente = "MediaUtente";
    private static string $tableNameLocandina = "MediaLocandina";

    private static string $valuesNameUtente = "(:id,:fileName,:mimeType,:idUtente,:date,:immagine)";
    private static string $valuesNameLocandina = "(:id,:fileName,:mimeType,:idFilm,:date,:immagine)";

    public function __construct() {}

    public static function associate(PDOStatement $sender, $media)
    {
        if ($media instanceof EMedia) {
            $path = $_FILES[$media->getFileName()]['tmp_name'];
            $file = fopen($path,"rb") or die ("Errore nell'apertura del file");
            $sender->bindValue(":id", $media->getId(), PDO::PARAM_INT);
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

            $sender->bindValue(':immagine', fread($file,filesize($path)), PDO::PARAM_LOB);

            unset($file);
            unlink($path);
        } else {
            die("Not a media!!");
        }
    }

    public static function getClassName()
    {
        return self::$className;
    }

    public static function getTableName(/*EMedia $media*/)
    {
       /* if ($media instanceof EMediaUtente) return self::$tableNameUtente;
        else if ($media instanceof EMediaLocandina) return self::$tableNameLocandina;*/
        return "MediaLocandina";
    }

    public static function getValuesName(EMedia $media)
    {
        if ($media instanceof EMediaUtente) return self::$valuesNameUtente;
        else if ($media instanceof EMediaLocandina) return self::$valuesNameLocandina;
    }

    public static function store(EMedia $media)
    {
        $db = FDatabase::getInstance();
        $db->storeMedia(static::getClassName(), $media);
    }

    public static function delete($value, $row): bool
    {
        $db = FDatabase::getInstance();
        if($db->deleteFromDB(self::getClassName(),$value,$row)){
            return true;
        }
        return false;
    }

    public static function update($value,$row,$newvalue,$newrow): bool
    {
        $db = FDatabase::getInstance();
        if($db->updateTheDB(self::getClassName(), $value, $row, $newvalue, $newrow))
        {
            return true;
        }
        return false;
    }

    public static function load (string $value, string $row)
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        if($result === null) {
            return null;
        }

        $row = $result[0];
        $idMedia = $row["idMedia"];
        $fileName = $row["fileName"];
        $mimeType = $row["mimeType"];
        $immagine = $row["immagine"];
        $date = $row["date"];
        $date = DateTime::createFromFormat('Y-m-d',$date);
        if (array_key_exists("idUtente", $row))
        {
            $idUtente = $row["idUtente"];
            $utente = FUtente::load($idUtente,"id");
            return new EMediaUtente($fileName, $mimeType, null, $immagine,$utente);
        }
        else if (array_key_exists("idFilm", $row))
        {
            $idFilm = $row["idFilm"];
            $film = FFilm::load($idFilm,'id')[0];
            return new EMediaLocandina($fileName, $mimeType, $date, $immagine, $film);
        }

        return null;
    }
}
