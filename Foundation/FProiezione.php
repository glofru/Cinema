<?php


class FProiezione
{
    private static string $className = "FProiezione";
    private static string $tableName = "Proiezioni";
    private static string $valuesName = "(:id,:idFilm,:data,:ora,:numerosala)";

    public function __construct() {}

    public function associate(PDOStatement $sender, EProiezione $proiezione) {
        $sender->bindValue(':id', NULL, PDO::PARAM_INT);
        $sender->bindValue(':idFilm', $proiezione->getFilm()->getId(), PDO::PARAM_INT);
        $sender->bindValue(':data',$proiezione->getDataSQL(),PDO::PARAM_STR);
        $sender->bindValue(':ora',$proiezione->getOra(),PDO::PARAM_STR);
        $sender->bindValue(':numerosala',$proiezione->getSala(),PDO::PARAM_BOOL);
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
        $test = $db->checkDisponibilita($proiezione->getSala()->getNumeroSala(),$proiezione->getData(),$proiezione->getOra());
        if(sizeof($test) < 2){
            $id = $db->saveToDB(self::getClassName(),$proiezione);
            $proiezione->setId($id);
            FPosto::store($proiezione);
            return true;
        } else {
            return $test;
        }
    }

    public static function load($value,$row,$puntuale,$inizio,$fine): array {
        $db = FDatabase::getInstance();
        if($puntuale === true) {
            $result = $db->loadFromDB(self::getClassName(),$value,$row);
        }
        else {
            $result = $db->loadBetween(self::getClassName(),$inizio,$fine,"data");
        }
        if($result === null) {
            return [];
        }
        $return = array();
        foreach ($result as $row)
        {
           //DATI DELLA PROIEZIONE
           $id = $row["idFilm"];
           $nSala = intval($row["nSala"]);
           $data = $row["data"];
           $ora = $row["ora"];
           //OTTENGO L'OGGETTO FILM
           $film = FFilm::load('id',$id)[0];
           //DATI DELLA SALAVIRTUALE
           //COSTRUISCO L'OGGETTO SALAVIRTUALE
           $salaV = ESalaVirtuale::fromSalaFisica(FSalaFisica::load($nSala,"numeroSala"));
           //COSTRUSICO L'OGGETTO DATAORA
            try {
                $dataora = new DateTime($data . "T" . $ora);
            } catch (Exception $e) {
                $dataora = time();
            }
            //AGGIUNGO LA PROIEZIONE ALLA LISTA DI RITORNO
           array_push($return,new EProiezione($film,$salaV,$dataora));
        }

        return $return;
    }

    public static function update($value,$row,$newvalue,$newrow): bool {
        $db = FDatabase::getInstance();
        if($db->updateTheDB(self::getClassName(),$value,$row,$newvalue,$newrow)){
            return true;
        }
        return false;
    }

    public static function delete($value,$row): bool {
        $db = FDatabase::getInstance();
        if($db->deleteFromDB(self::getClassName(),$value,$row)){
            return true;
        }
        return false;
    }

    public static function occupaPosto($idProiezione,$posto,$emailUtente,$costo) {
        $db = FDatabase::getInstance();
        $biglietto = $db->occupaPosto($idProiezione,$posto,$emailUtente,$costo);
        return $biglietto;
    }

    public static function liberaPosto($idProiezione,$posto,$emailUtente) {
        $db = FDatabase::getInstance();
        $return = $db->liberaPosto($idProiezione,$posto, $emailUtente);
        return $return;
    }


}