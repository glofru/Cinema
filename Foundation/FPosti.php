<?php


class FPosti
{
    private static string $className = "FPosti";
    private static string $tableName = "Posti";
    private static string $valuesName = "(:idProiezione,:posizione,:libero)";

    public function __construct() {}

    public function associate(PDOStatement $sender, EProiezione $proiezione, EPosto $posto){
        $sender->bindValue(':idProiezione', $proiezione->getId(), PDO::PARAM_INT);
        $sender->bindValue(':posizione', $posto->getFila() ." ".strval($posto->getNumeroPosto()), PDO::PARAM_STR);
        $sender->bindValue(':libero', true, PDO::PARAM_BOOL);
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
            $db->saveToDBPosti(self::getClassName(),$proiezione,$elem);
        }
    }

    public static function load(EProiezione $proiezione) {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(),$proiezione->getId(),"idProiezione");
        if($result === null){
            return $result;
        }
        $return = [];
        foreach ($result as $elem) {
            $elem2 = explode(" ",$elem);
            array_push($return,new EPosto($elem2[0],intval($elem2[1]),$elem["libero"]));
        }
        return $return;
    }

    public static function loadDoppio(EProiezione $proiezione, string $posto) {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDBDebole(self::getClassName(),$proiezione->getId(),"idProiezione",$posto,"posizione");
        if($result === null){
            return $result;
        }
        $libero = $result["libero"];
        $elem = explode(" ",$posto);
        $return = new EPosto($elem[0],intval($elem[1]),$libero);
        return $return;
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