<?php


class FNewsLetter
{
    private static string $className = "FNewsLetter";
    private static string $tableName = "NewsLetter";
    private static string $valuesName = "(:idUtente,:preferenze)";

    public function __construct() {}

    public static function associate(PDOStatement $sender, ERegistrato $utente, string $preferenze) {
        $sender->bindValue(':idUtente', $utente->getId(), PDO::PARAM_INT);
        $sender->bindValue(':preferenze', $preferenze, PDO::PARAM_STR);
    }

    public static function getClassName() {
        return self::$className;
    }

    public static function getTableName() {
        return self::$tableName;
    }

    public static function getValuesName() {
        return self::$valuesName;
    }

    public static function save(EUtente $utente, $preferenze) {
        $db = FDatabase::getInstance();
        $db->saveToDBNS($utente, $preferenze);
    }

    public static function load($utente)  {
            $result = FDatabase::getInstance()->loadFromDB(self::getClassName(), $utente, "idUtente");
            return $result[0]["preferenze"];
    }

    public static function loadAll() {
        $db = FDatabase::getInstance();
        $result = $db->loadAll(self::getClassName());
        if($result === null){
            return new ENewsLetter();
        }

        return self::parseResult($result);
    }

    public static function update($value, $row, $newvalue, $newrow): bool {
        $db = FDatabase::getInstance();
        if($db->updateTheDB(self::getClassName(), $value, $row, $newvalue, $newrow)){
            return true;
        }
        return false;
    }

    public static function delete($value, $row): bool {
        $db = FDatabase::getInstance();
        if($db->deleteFromDB(self::getClassName(), $value, $row)){
            return true;
        }
        return false;
    }

    private static function parseResult($result): ENewsLetter {
        $ns = new ENewsLetter();
        foreach ($result as $utente) {
            $whois = FUtente::load($utente["idUtente"], "id");
            $ns->addUtenteEPreferenzaFromRaw($whois, $utente["preferenze"]);
        }
        return $ns;
    }

    public static function isASub(ERegistrato $utente): bool {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $utente->getId(), "idUtente");
        return (sizeof($result) !== 0);
    }

}