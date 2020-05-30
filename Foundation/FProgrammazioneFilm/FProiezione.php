<?php


class FProiezione implements Foundation
{
    private static string $className = "FProiezione";
    private static string $tableName = "Proiezione";
    private static string $valuesName = "(:id,:data,:ora,:numerosala,:idFilm)";

    public function __construct() {}

    public static function associate(PDOStatement $sender, $proiezione) {
        if ($proiezione instanceof EProiezione) {
            $sender->bindValue(':id', NULL, PDO::PARAM_INT);
            $sender->bindValue(':data',$proiezione->getDataSQL(),PDO::PARAM_STR);
            $sender->bindValue(':ora',$proiezione->getOra(),PDO::PARAM_STR);
            $sender->bindValue(':numerosala',$proiezione->getSala()->getNumeroSala(),PDO::PARAM_INT);
            $sender->bindValue(':idFilm', $proiezione->getFilm()->getId(), PDO::PARAM_INT);
        } else {
            die("Not a projection!!");
        }
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
    public static function save(EProiezione $proiezione) {
        $db = FDatabase::getInstance();
        $test = $db->checkDisponibilita($proiezione->getSala()->getNumeroSala(), $proiezione->getDataSQL(), $proiezione->getOra());
        if(sizeof($test) < 1){
            $id = $db->saveToDB(self::getClassName(), $proiezione);
            $proiezione->setId($id);
            FPosto::store($proiezione);
            return true;
        }

        return $test;
    }

    public static function load($value, $row): EElencoProgrammazioni {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        return self::parseResult($result);
    }

    public static function loadBetween($inizio, $fine): EElencoProgrammazioni {
        $db = FDatabase::getInstance();
        $result = $db->loadBetween(self::getClassName(), $inizio, $fine, "data");

        return self::parseResult($result);
    }

    public static function update($value, $row, $newvalue, $newrow): bool {
        $db = FDatabase::getInstance();

        return $db->updateTheDB(self::getClassName(), $value, $row, $newvalue, $newrow);
    }

    public static function delete($value,$row): bool {
        $db = FDatabase::getInstance();
        if($db->deleteFromDB(self::getClassName(),$value,$row)){
            return true;
        }
        return false;
    }

    public static function occupaPosti(array $biglietti): bool {
        $db = FDatabase::getInstance();
        return $db->occupaPosti($biglietti);
    }

    public static function liberaPosto($idProiezione, $posto, $emailUtente) {
        $db = FDatabase::getInstance();
        return $db->liberaPosto($idProiezione, $posto, $emailUtente);
    }

    private static function parseResult(array $result)
    {
        $elencoProgrammazioni = new EElencoProgrammazioni();

        foreach ($result as $row) {
            $elencoProgrammazioni->addProiezione(self::parseProiezione($row));
        }

        return $elencoProgrammazioni;
    }

    private static function parseProiezione($row): EProiezione {
        $id = $row["id"];
        $data = $row["data"];
        $ora = $row["ora"];

        //OTTENGO L'OGGETTO FILM
        $film = FFilm::load($row["idFilm"], "id")[0];

        //COSTRUISCO L'OGGETTO SALAVIRTUALE
        $sala = FSala::loadVirtuale($row["numerosala"], "nSala");
        $posti = FPosto::load($id, "idProiezione");

        foreach($posti as $posto) {
            echo $posto->getPosto . " " . "<br>";
            if ($posto->isOccupato() == true) {
               echo $posto->getPosto . " " . strval($sala->occupaPosto($posto)) . "<br>";
            }
        }

        //COSTRUSICO L'OGGETTO DATAORA
        try {
            $dataora = new DateTime($data . "T" . $ora);
        } catch (Exception $e) {
            $dataora = time();
        }

        //AGGIUNGO LA PROIEZIONE ALLA LISTA DI RITORNO
        $proiezione = new EProiezione($film, $sala, $dataora);
        $proiezione->setId($id);

        return $proiezione;
    }
}