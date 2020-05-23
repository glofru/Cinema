<?php


class FPersona implements Foundation
{
    private static string $className = "FPersona";
    private static string $tableName = "Persona";
    private static string $valuesName = "(:id,:nome,:cognome,:imdbURL,:isAttore,:isRegista)";

    public function __construct() {}

    public static function associate(PDOStatement $sender, $persona) {
        if ($persona instanceof EPersona) {
            $sender->bindValue(':id', $persona->getId(), PDO::PARAM_INT);
            $sender->bindValue(':nome', $persona->getNome(), PDO::PARAM_STR);
            $sender->bindValue(':cognome', $persona->getCognome(), PDO::PARAM_STR);
            $sender->bindValue(':imdbURL', $persona->getImdbUrl(), PDO::PARAM_STR);
            $sender->bindValue(':isAttore', $persona->isAttore(), PDO::PARAM_BOOL);
            $sender->bindValue(':isRegista', $persona->isRegista(), PDO::PARAM_BOOL);
        } else {
            die("Not a person!!");
        }
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
        $id = $row["id"];
        $nome = $row["nome"];
        $cognome = $row["cognome"];
        $imdbUrl = $row["imdbURL"];
        $isAttore = $row["isAttore"];
        $isRegista = $row["isRegista"];
        $p = new EPersona($nome, $cognome, $imdbUrl, boolval($isAttore), boolval($isRegista));
        $p->setId($id);
        return $p;
    }
}