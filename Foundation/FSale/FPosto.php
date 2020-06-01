<?php


class FPosto implements FoundationDebole
{
    private static string $className = "FPosto";
    private static string $tableName = "Posti";
    private static string $valuesName = "(:idProiezione,:posizione,:occupato)";

    public function __construct() {}

    public static function associate(PDOStatement $sender, $proiezione, $posto) {
        if ($proiezione instanceof EProiezione && $posto instanceof EPosto) {
            $sender->bindValue(':idProiezione', $proiezione->getId(), PDO::PARAM_INT);
            $sender->bindValue(':posizione', $posto->getId(), PDO::PARAM_STR);
            $sender->bindValue(':occupato', $posto->isOccupato(), PDO::PARAM_BOOL);
        } else {
            die("Problems");
        }
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
//------------- ALTRI METODI ----------------

    public static function store(EProiezione $proiezione) {
        $db = FDatabase::getInstance();
        foreach ($proiezione->getSala()->getPosti() as $elem) {
            $db->saveToDBDebole(self::getClassName(), $proiezione, $elem);
        }
    }

    public static function load(string $value, string $row) {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $value,$row);
        if($result === null){
            return null;
        }

        $return = [];

        foreach ($result as $elem) {
            $occupato = $elem["occupato"] === "1";
            array_push($return,EPosto::fromDB($elem["posizione"], $occupato));
        }

        return $return;
    }

    public static function loadDoppio($idProiezione, string $posto) {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDBDebole(self::getClassName(), $idProiezione, "idProiezione", $posto, "posizione");
        if($result === null){
            return $result;
        }
        $occupato = boolval($result[0]["occupato"]);
        return EPosto::fromDB($posto, $occupato);
    }

    public static function update($value, $row, $value2, $row2, $newvalue, $newrow): bool {
        $db = FDatabase::getInstance();
        if($db->updateTheDBDebole(self::getClassName(), $value, $row, $value2, $row2, $newvalue, $newrow)){
            return true;
        }
        return false;
    }

    public static function delete($value, $row, $value2, $row2): bool {
        $db = FDatabase::getInstance();
        if($db->deleteFromDB(self::getClassName(), $value, $row)) {
            return true;
        }
        return false;
    }
}