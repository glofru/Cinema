<?php


class FNewsLetter
{
    private static string $className = "FNewsLetter";
    private static string $tableName = "NewsLetter";
    private static string $valuesName = "(:idUtente,:preferenze)";

    public function __construct() {}

    public static function associate(PDOStatement $sender, ERegistrato $utente, string $preferenze) {
        $sender->bindValue(':idUtente', $utente->getId(), PDO::PARAM_INT);
        $sender->bindValue(':preferenze', $preferenze, PDO::PARAM_INT);
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

    public static function load() {
        $db = FDatabase::getInstance();
        $result = $db->loadAllNL();
        if($result === null){
            return new ENewsLetter();
        }

        return self::parseResult($result);
    }

    public static function update($value, $row, $value2, $row2, $newvalue, $newrow): bool {
        $db = FDatabase::getInstance();
        if($db->updateTheDBDebole(self::getClassName(), $value, $row, $value2, $row2, $newvalue, $newrow)){
            return true;
        }
        return false;
    }

    public static function delete($value, $row, $value2, $row2): bool {
        $db = FDatabase::getInstance();
        if($db->deleteFromDBDebole(self::getClassName(), $value, $row, $value2, $row2)){
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

}