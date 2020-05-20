<?php


class FPersona
{
    private static string $className = "FPersona";
    private static string $tableName = "Persona";
    private static string $valuesName = "(:idPersona,:nome,:cognome,:imdbUrl,:isAttore,:isRegista)";

    public function __construct() {}

    public function associate(PDOStatement $sender, EPersona $persona) {
        $sender->bindValue(':idPersona', $persona->getId(), PDO::PARAM_INT);
        $sender->bindValue(':nome', $persona->getNome(), PDO::PARAM_STR);
        $sender->bindValue(':cognome', $persona->getCognome(), PDO::PARAM_STR);
        $sender->bindValue(':imdbUrl', $persona->getImdbUrl(), PDO::PARAM_STR);
        $sender->bindValue(':isAttore', $persona->isAttore(), PDO::PARAM_BOOL);
        $sender->bindValue(':isRegista', $persona->isRegista(), PDO::PARAM_BOOL);
    }

    public static function getClassName()
    {
        return self::$className;
    }

    public static function getTableName()
    {
        return self::$tableName;
    }

    public static function getValuesName()
    {
        return self::$valuesName;
    }

    public static function save(EPersona $persona)
    {
        $db = FDatabase::getInstance();
        $db->saveToDB(self::getClassName(), $persona);
    }

    public static function update($value, $row, $newvalue, $newrow): bool
    {
        $db = FDatabase::getInstance();
        
        if($db->updateTheDB(self::getClassName(), $value, $row, $newvalue, $newrow))
        {
            return true;
        }

        return false;
    }

    public static function delete($value, $row): bool {
        $db = FDatabase::getInstance();
        if($db->deleteFromDB(self::getClassName(),$value,$row)){
            return true;
        }
        return false;
    }

    public static function load (string $value, string $row)
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        if ($result == null || sizeof($result) == 0)
        {
            return [];
        }

        $row = $result[0];
        $id = $row["idPersona"];
        $nome = $row["nome"];
        $cognome = $row["cognome"];
        $imdbUrl = $row["imbdUrl"];
        $isAttore = $row["isAttore"];
        $isRegista = $row["isRegista"];

        return new EPersona($id, $nome, $cognome, $imdbUrl, $isAttore, $isRegista);
    }
}