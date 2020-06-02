<?php


class FToken implements Foundation
{
    private static string $className = "FToken";
    private static string $tableName = "Token";
    private static string $valuesName = "(:value,:creationDate,:creationHour,:idUtente)";

    public static function associate(PDOStatement $sender, $token){
        if ($token instanceof EToken) {
            $sender->bindValue(':value', $token->getValue(), PDO::PARAM_STR);
            $sender->bindValue(':creationDate', $token->getCreationdateDB(), PDO::PARAM_STR);
            $sender->bindValue(':creationHour', $token->getCreationHour(), PDO::PARAM_STR);
            $sender->bindValue(':idUtente', $token->getUtente()->getId(), PDO::PARAM_STR);
        } else {
            die("Not a token!!");
        }
    }

    public static function getClassName(): string {
        return self::$className;
    }

    public static function getTableName(): string {
        return self::$tableName;
    }

    public static function getValuesName(): string {
        return self::$valuesName;
    }

    public static function load(string $value, string $row) {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        if ($result == null) {
            return null;
        }

        $row = $result[0];
        $value = $row["value"];
        $creationDate = new DateTime($row["creationDate"] . "T" . $row["creationHour"]);

        $utente = FUtente::load($row["idUtente"], "id");

        return new EToken($value, $creationDate, $utente);
    }

    public static function update($value, $row, $newvalue, $newrow): bool {
        $db = FDatabase::getInstance();

        return $db->updateTheDB(self::getClassName(), $value, $row, $newvalue, $newrow);
    }

    public static function delete($value, $row): bool {
        $db = FDatabase::getInstance();

        return $db->deleteFromDB(self::getClassName(), $value, $row);
    }

    public static function save(EToken $token) {
        $db = FDatabase::getInstance();
        $db->saveToDB(self::getClassName(), $token);
    }
}