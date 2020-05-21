<?php


class FGiudizio
{
    private static string $className = "FRegistrato";
    private static string $tableName = "Registrato";
    private static string $valuesName = "(:idUtente,:film,:punteggio,:commento)";

    public function __construct()
    {

    }
    public function associate(PDOStatement $sender, EGiudizio $giudizio, FRegistrato $registrato)
    {
        $sender->bindValue(':idUtente', $registrato->getidRegistrato(), PDO::PARAM_INT);
        $sender->bindValue(':film', $giudizio->getFilm(), PDO::PARAM_STR);
        $sender->bindValue(':emailUtente', $giudizio->getPunteggio(), PDO::PARAM_INT);
        $sender->bindValue(':costo', $giudizio->getCommento(), PDO::PARAM_STR);
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

    public static function load(string  $value, string $row)
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        if ($result == null || sizeof($result) == 0)
        {
            return null;
        }

        $row = $result[0];
        $idRegistrato = $row["idUtente"];
        $film = $row["film"];
        $punteggio = $row["commento"];
        $commento = $row["punteggio"];

        return new EGiudizio($idRegistrato, $film, $punteggio, $commento);

    }

    public static function loadDoppio($value,$row,$value2,$row2): EGiudizio
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDBDebole(self::getClassName(),$value,$row,$value2,$row2);
        if($result === null)
        {
            return $result;
        }

        $idRegistrato = $result["idUtente"];
        $film = $row["film"];
        $punteggio = $row["commento"];
        $commento = $row["punteggio"];



        return new EGiudizio($idRegistrato, $film, $punteggio, $commento);
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






}