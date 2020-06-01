<?php


class FToken implements Foundation
{
    private static string $className = "FToken";
    private static string $tableName = "Token";
    private static string $valuesName = "(:value,:used)";

    public static function associate(PDOStatement $sender, $token){
        if ($token instanceof EToken) {
            $sender->bindValue(':value', $token->getValue(), PDO::PARAM_INT);
            $sender->bindValue(':username', $token->isUsed(), PDO::PARAM_BOOL);
        } else {
            die("Not a token!!");
        }
    }

    public static function load(string $value, string $row) {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        if ($result == null) {
            return null;
        }

        $row = $result[0];
        $value = $row["value"];
        $isUsed = boolval($row["isUsed"]);

        return new EToken($value, $isUsed);
    }

    public static function update($value, $row, $newvalue, $newrow): bool {
        $db = FDatabase::getInstance();

        return $db->updateTheDB(self::getClassName(), $value, $row, $newvalue, $newrow);
    }

    public static function delete($value, $row): bool {
        $db = FDatabase::getInstance();

        return $db->deleteFromDB(self::getClassName(), $value, $row);
    }
}