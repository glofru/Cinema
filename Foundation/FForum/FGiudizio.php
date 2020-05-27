<?php


class FGiudizio
{
    private static string $className = "FGiudizio";
    private static string $tableName = "Giudizio";
    private static string $valuesName = "(:idUtente,:idFilm,:commento,:punteggio,:titolo,:datapubblicazione)";

    public function __construct()
    {

    }
    public function associate(PDOStatement $sender, EGiudizio $giudizio)
    {
        $sender->bindValue(':idUtente', $giudizio->getUtente()->getId(), PDO::PARAM_INT);
        $sender->bindValue(':idFilm', $giudizio->getFilm()->getId(), PDO::PARAM_INT);
        $sender->bindValue(':commento', $giudizio->getCommento(), PDO::PARAM_STR);
        $sender->bindValue(':punteggio', strval($giudizio->getPunteggio()), PDO::PARAM_STR);
        $sender->bindValue(':titolo', $giudizio->getTitle(), PDO::PARAM_STR);
        $sender->bindValue(':datapubblicazione', $giudizio->getDataPubblicazioneDB(), PDO::PARAM_STR);
    }
    //----------------- GETTER --------------------
    public static function getClassName() {
        return self::$className;
    }

    public static function getTableName() {
        return self::$tableName;
    }

    public static function getValuesName() {
        return self::$valuesName;
    }

    public static function save(EGiudizio $giudizio) {
        $db = FDatabase::getInstance();
        $db->saveToDB(self::getClassName(),$giudizio);
    }

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

    public static function update($value,$row,$value2,$row2,$newvalue,$newrow): bool
    {
        $db = FDatabase::getInstance();
        if($db->updateTheDBDebole(self::getClassName(),$value,$row,$value2,$row2,$newvalue,$newrow)){
            return true;
        }
        return false;
    }

    public static function delete($value,$row,$value2,$row2): bool
    {
        $db = FDatabase::getInstance();
        if($db->deleteFromDBDebole(self::getClassName(),$value,$row,$value2,$row2)){
            return true;
        }
        return false;
    }

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