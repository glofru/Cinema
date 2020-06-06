<?php


class FSala implements Foundation
{
    private static string $className = "FSala";
    private static string $tableName = "salaFisica";
    private static string $valuesName = "(:nSala,:nFile,:nPostiFila,:disponibile)";

    public function __construct() {}

    public static function associate(PDOStatement $sender, $salaFisica){
        if ($salaFisica instanceof ESalaFisica) {
            $sender->bindValue(':nSala', $salaFisica->getNumeroSala(), PDO::PARAM_INT);
            $sender->bindValue(':nFile', $salaFisica->getNFile(), PDO::PARAM_INT);
            $sender->bindValue(':nPostiFila', $salaFisica->getNPostiFila(), PDO::PARAM_STR);
            $sender->bindValue(':disponibile', $salaFisica->isDisponibile(), PDO::PARAM_STR);
        } else {
            die("Not a phisical room!!");
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
    public static function save(ESalaFisica $salaFisica) {
        $db = FDatabase::getInstance();
        $db->saveToDB(self::getClassName(),$salaFisica);
    }

    public static function nLoadAll(): int {
        $db = FDatabase::getInstance();
        $result = $db->loadAllNL(self::getClassName());
        if($result === null){
            return 0;
        }
        return sizeof($result);
    }

    public static function load (string $nSala, string $row) {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), intval($nSala), $row);
        if($result === null){
            return null;
        }

        $nSala = $result[0]["nSala"];
        $nFile = $result[0]["nFile"];
        $nPostiFila = $result[0]["nPostiFila"];
        $disponibile = $result[0]["disponibile"];
        return new ESalaFisica($nSala, $nFile, $nPostiFila, $disponibile);
    }

    public static function loadVirtuale (string $nSala, string $row) {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), intval($nSala), $row);
        if($result === null){
            return null;
        }

        $nSala = $result[0]["nSala"];
        $nFile = $result[0]["nFile"];
        $nPostiFila = $result[0]["nPostiFila"];
        $disponibile = $result[0]["disponibile"];
        return new ESalaVirtuale($nSala, $nFile, $nPostiFila, $disponibile);
    }

    public static function update($value,$row,$newvalue,$newrow): bool {
        $db = FDatabase::getInstance();
        if($db->updateTheDB(self::getClassName(),$value,$row,$newvalue,$newrow)){
            return true;
        }
        return false;
    }

    public static function delete($value,$row): bool {
        $db = FDatabase::getInstance();
        if($db->deleteFromDB(self::getClassName(),$value,$row)){
            return true;
        }
        return false;
    }
}