<?php


class FBiglietti
{
    private static string $className = "FBiglietti";
    private static string $tableName = "Biglietto";
    private static string $valuesName = "(:idProiezione,:posto,:emailUtente,:costo";

    public function __construct() {}

    public function associate(PDOStatement $sender, EBiglietto $biglietto) {
        $sender->bindValue(':idProiezione', $biglietto->getProiezione()->getId(), PDO::PARAM_INT);
        $sender->bindValue(':posto', $biglietto->getPosto(), PDO::PARAM_STR);
        $sender->bindValue(':emailUtente',$biglietto->getUtente()->getEmail(),PDO::PARAM_STR);
        $sender->bindValue(':costo',$biglietto->getCosto(),PDO::PARAM_STR);
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

    public static function load($value,$row): array {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(),$value,$row);
        if($result === null){
            return $result;
        }
        $return = [];
        foreach ($result as $elem) {
            //PROIEZIONE
            $id = $elem["idProiezione"];
            $proiezione = new FProiezioni();
            $proiezione = $proiezione->load($id,"id",true,null,null)[0];
            //POSTO
            $posto = $elem["posto"];
            $temp = new FPosti();
            $posto = $temp->loadDoppio($proiezione,$posto);
            //UTENTE
            $email = $elem["emailUtente"];
            $utente = FUtente::loadEmail($email);
            array_push($return,new EBiglietto($proiezione,$posto,$utente,floatval($elem["costo"])));
        }
        return $return;
    }

    public static function loadDoppio($value,$row,$value2,$row2): EBiglietto {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDBDebole(self::getClassName(),$value,$row,$value2,$row2);
        if($result === null){
            return $result;
        }
        //PROIEZIONE
        $id = $result["idProiezione"];
        $proiezione = FProiezioni::load($id,"id",true,null,null)[0];
        //POSTO
        $posto = $result["posto"];
        $posto = FPosti::loadDoppio($proiezione,$posto);
        //UTENTE
        $email = $result["emailUtente"];
        $utente = FUtente::load($email);
        return new EBiglietto($proiezione,$posto,$utente,floatval($result["costo"]));
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
}