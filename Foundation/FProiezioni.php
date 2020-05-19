<?php


class FProiezioni
{
    private static string $className = "FProiezioni";
    private static string $tableName = "Proiezioni";
    private static string $valuesName = "(:id,:idFilm,:data,:ora,:numerosala)";

    public function __construct() {}

    public function associate(PDOStatement $sender, EProiezione $proiezione) {
        $sender->bindValue(':id', NULL, PDO::PARAM_INT);
        $sender->bindValue(':idFilm', $proiezione->getFilm()->getId(), PDO::PARAM_INT);
        $sender->bindValue(':data',$proiezione->getData(),PDO::PARAM_INT);
        $sender->bindValue(':ora',$proiezione->getOra(),PDO::PARAM_INT);
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
            FPosti::store($proiezione);
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
            $result = $db->loadBetweenProiezione($inizio,$fine);
        }
        if($result === null) {
            return [];
        }
        $return = array();
        for($i=0;$i<sizeof($result);$i++) {
           //DATI DELLA PROIEZIONE
           $id = $return[$i]["idFilm"];
           $nSala = intval($return[$i]["nSala"]);
           $data = $return[$i]["data"];
           $ora = $return[$i]["ora"];
           //DATI DEL FILM
           $film = FFilm::load('id',$id);
           $durata = DateInterval::createFromDateString($film["durata"]);
           $dataRilascio = DateTime::createFromFormat('Y-m-d', $film["dataRilascio"]);
           $genere = EGenere::fromString($film["genere"]);
           //DATI DELLA SALAVIRTUALE
           //COSTRUISCO L'OGGETTO SALAVIRTUALE
           $salaV = ESalaVirtuale::fromSalaFisica(FSalaFisica::load($nSala,"numeroSala"));
           //COSTRUISCO L'OGGETTO FILM
           $film = new EFilm($id,$film["nome"],$film["descrizione"],$durata,$film["trailerURL"],$film["votoCritica"],$dataRilascio,$genere);
           //COSTRUSICO L'OGGETTO DATAORA
           $dataora = new DateTime($data . "T" . $ora);
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