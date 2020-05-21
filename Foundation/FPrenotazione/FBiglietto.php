<?php


class FBiglietto implements Foundation
{
    private static string $className = "FBiglietto";
    private static string $tableName = "Biglietto";
    private static string $valuesName = "(:idProiezione,:posto,:idUtente,:costo";

    public function __construct() {}

    public static function associate(PDOStatement $sender, $biglietto) {
        if ($biglietto instanceof EBiglietto) {
            $sender->bindValue(':idProiezione', $biglietto->getProiezione()->getId(), PDO::PARAM_INT);
            $sender->bindValue(':posto', $biglietto->getPosto(), PDO::PARAM_STR);
            $sender->bindValue(':idUtente',$biglietto->getUtente()->getId(),PDO::PARAM_INT);
            $sender->bindValue(':costo',$biglietto->getCosto(),PDO::PARAM_STR);
        } else {
            die("Not a ticket!!");
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
    public static function save(EBiglietto $biglietto) {
        $db = FDatabase::getInstance();
        $db->saveToDB(self::getClassName(),$biglietto);
    }

    public static function load($value,$row) {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(),$value,$row);
        if($result === null){
            return null;
        }

        return self::parseResult($result);
    }

    public static function loadDoppio($value,$row,$value2,$row2): EBiglietto {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDBDebole(self::getClassName(),$value,$row,$value2,$row2);
        if($result === null){
            return $result;
        }

        return self::parseResult($result)[0];
    }

    public static function update($value,$row,$value2,$row2,$newvalue,$newrow): bool {
        $db = FDatabase::getInstance();
        if($db->updateTheDBDebole(self::getClassName(),$value,$row,$value2,$row2,$newvalue,$newrow)){
            return true;
        }
        return false;
    }

    public static function delete($value,$row,$value2,$row2): bool {
        $db = FDatabase::getInstance();
        if($db->deleteFromDBDebole(self::getClassName(),$value,$row,$value2,$row2)){
            return true;
        }
        return false;
    }

    private static function parseResult(array $result): array
    {
        $return = [];
        foreach ($result as $row) {
            //PROIEZIONE
            $id = $row["idProiezione"];
            $proiezione = FProiezione::load($id, "id", true, null, null)[0];
            //POSTO
            $posto = $row["posto"];
            $posto = FPosto::loadDoppio($proiezione, $posto);
            //UTENTE
            $utente = FUtente::load(intval($result["idUtente"]));
            $costo = floatval($row["costo"]);
            array_push($return, new EBiglietto($proiezione,$posto,$utente,$costo));
        }
        return $return;
    }
}