<?php


class FSalaFisica
{
    private static string $className = "FSalaFisica";
    private static string $tableName = "SalaFisica";
    private static string $valuesName = "(:nsala,:nFile,:nPostiFila,:disponibile)";

    public function __construct() {}

    public function associate(PDOStatement $sender, ESalaFisica $salaFisica){
        $sender->bindValue(':nsala', $salaFisica->getNumeroSala(), PDO::PARAM_INT);
        $sender->bindValue(':nFile', $salaFisica->getNFile(), PDO::PARAM_INT);
        $sender->bindValue(':nPostiFila', $salaFisica->getNPostiFila(), PDO::PARAM_STR);
        $sender->bindValue(':disponibile', $salaFisica->isDisponibile(), PDO::PARAM_STR);
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
    public function save(ESalaFisica $salaFisica) {
        $db = FDatabase::getInstance();
        $db->saveToDB($this->getClassName(),$salaFisica);
    }

    public function load ($nSala) {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB($this->getClassName(),$nSala,"nSala");
        if($result === null){
            return $result;
        }
        $sala = new ESalaFisica($result["nSala"],$result["nFile"],$result["nPostiFila"],$result["disponibile"]);
        return ESalaVirtuale::fromSalaFisica($sala);
    }

    public function update($value,$row,$newvalue,$newrow): bool {
        $db = FDatabase::getInstance();
        if($db->updateTheDB($this->getClassName(),$value,$row,$newvalue,$newrow)){
            return true;
        }
        return false;
    }

    public function delete($value,$row): bool {
        $db = FDatabase::getInstance();
        if($db->deleteFromDB($this->getClassName(),$value,$row)){
            return true;
        }
        return false;
    }
}