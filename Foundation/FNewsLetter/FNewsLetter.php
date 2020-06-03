<?php


class FNewsLetter
{
    private static string $className = "FNewsLetter";
    private static string $tableName = "NewsLetter";
    private static string $valuesName = "(:idUtente)";

    public function __construct() {}

    public static function associate(PDOStatement $sender, EUtente $utente) {
        $sender->bindValue(':idUtente', $utente->getId(), PDO::PARAM_INT);
    }

    public static function getClassName() {
        return self::$className;
    }

    public static function getTableName() {
        return self::$tableName;
    }

    public static function getValuesName() {
        return self::$valuesName;
    }

    public static function save(EUtente $utente) {
        $db = FDatabase::getInstance();
        $db->saveToDB(self::getClassName(), $utente);
    }

    public static function load() {
        $db = FDatabase::getInstance();
        $result = $db->loadAllNL();
        if($result === null){
            return null;
        }

        return self::parseResult($result);
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
        if($db->deleteFromDBDebole(self::getClassName(), $value, $row, $value2, $row2)){
            return true;
        }
        return false;
    }

    private static function parseResult($result): array {
        $return = [];
        foreach ($result as $utente) {
            $utente = FUtente::load($utente["idUtente"], "id");
            array_push($return, $utente);
        }
        return $return;
    }

}