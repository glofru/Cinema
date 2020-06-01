<?php


class FUtente implements Foundation
{
    private static string $className = "FUtente";
    private static string $tableName = "Utenti";
    private static string $valuesName = "(:id,:username,:email,:nome,:cognome,:password,:isAdmin,:isBanned)";

    public function __construct() {}

    public static function associate(PDOStatement $sender, $utente){
        if ($utente instanceof EUtente) {
            $sender->bindValue(':id', NULL, PDO::PARAM_INT);
            $sender->bindValue(':username', $utente->getUsername(), PDO::PARAM_STR);
            $sender->bindValue(':email', $utente->getEmail(), PDO::PARAM_STR);
            $sender->bindValue(':nome', $utente->getNome(), PDO::PARAM_STR);
            $sender->bindValue(':cognome', $utente->getCognome(), PDO::PARAM_STR);
            $sender->bindValue(':password', $utente->getPassword(), PDO::PARAM_STR);
            $sender->bindValue(':isAdmin', $utente instanceof EAdmin, PDO::PARAM_BOOL);
            $sender->bindValue(':isBanned', $utente->isBanned(), PDO::PARAM_BOOL);
        } else {
            die("Not a user!!");
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

    public static function save(EUtente $utente) {
        $db = FDatabase::getInstance();
        $id = $db->saveToDB(self::getClassName(), $utente);
        $utente->setId($id);
    }

    public static function load(string  $value, string $row) {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        if ($result == null) {
            return null;
        }
        return self::parseResult($result)[0];
    }

    public static function loadBannati() {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), '1', 'isBanned');
        if ($result == null) {
            return [];
        }
        return self::parseResult($result);
    }

    public static function login(string $value, string $pass, bool $isMail) {
        $db = FDatabase::getInstance();

        if($isMail) {
            $result = $db->loadFromDB(self::getClassName(), $value, "email");
        } else {
            $result = $db->loadFromDB(self::getClassName(), $value, "username");
        }

        $utente = self::parseResult($result)[0];

        if ($utente != null) {
            if (password_verify($pass, $utente->getPassword())) {
                return $utente;
            }
        }

        return null;
    }

    public static function update($value, $row, $newvalue, $newrow): bool {
        $db = FDatabase::getInstance();

        return $db->updateTheDB(self::getClassName(), $value, $row, $newvalue, $newrow);
    }

    public static function delete($value, $row): bool {
        $db = FDatabase::getInstance();

        return $db->deleteFromDB(self::getClassName(), $value, $row);
    }

    private static function parseResult(array $result): array {
        $return = [];

        foreach ($result as $row) {
            $id = $row["id"];
            $nome = $row["nome"];
            $cognome = $row["cognome"];
            $username = $row["username"];
            $email = $row["email"];
            $password = $row["password"];
            $isAdmin = $row["isAdmin"];
            $isBanned = $row["isBanned"];

            if ($isAdmin) {
                $utente = new EAdmin($nome, $cognome, $username, $email, $password, $isBanned);
            } elseif ($username != null && $username != "") {
                $utente =  new EUtente($nome, $cognome, $username, $email, $password, $isBanned);
            } else {
                $utente = new ENonRegistrato($nome, $cognome, $username, $email, $password, $isBanned);
            }

            $utente->setId($id);
            array_push($return, $utente);
        }

        return $return;
    }

    public static function exists(EUtente $utente, bool $checkMail = null): bool {
        $db = FDatabase::getInstance();

        $resultMail = $db->loadFromDB(self::getClassName(), $utente->getEmail(), "email");
        $existsMail = $resultMail != null && sizeof($resultMail) > 1;

        if ($checkMail) return $existsMail;

        $resultUser = $db->loadFromDB(self::getClassName(), $utente->getUsername(), "username");
        $existsUser = $resultUser != null && sizeof($resultUser) > 1;

        if (!$checkMail) return $existsUser;

        return $existsMail && $existsUser;
    }
}