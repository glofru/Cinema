<?php


class FBiglietto
{
    private static string $className = "FBiglietto";
    private static string $tableName = "Biglietto";
    private static string $valuesName = "(:idProiezione,:posto,:emailUtente,:costo";

    public function __construct() {}

    public function associate(PDOStatement $sender, EBiglietto $biglietto) {
        $sender->bindValue(':idProiezione', $biglietto->getProiezione()->getId(), PDO::PARAM_INT);
        $sender->bindValue(':posto', $biglietto->getPosto(), PDO::PARAM_INT);
        $sender->bindValue(':data',$biglietto->getUtente()->getEmail(),PDO::PARAM_INT);
        $sender->bindValue(':ora',$biglietto->getCosto(),PDO::PARAM_INT);
    }
//----------------- GETTER --------------------
    public function getClassName() {
        return self::$className;
    }

    public function getTableName() {
        return self::$tableName;
    }

    public function getValuesName() {
        return self::$valuesName;
    }

//------------- ALTRI METODI ----------------

public function store() {

}
}