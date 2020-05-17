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
    public function getClassName() {
        return self::$className;
    }

    public function getTableName() {
        return self::$tableName;
    }

    public function getValuesName() {
        return self::$valuesName;
    }

//------------- ALTRI METODI ----------------
    public function save(EProiezione $proiezione) {
        $db = FDatabase::getInstance();
        $id = $db->saveToDB($this->getClassName(),$proiezione);
        $proiezione->setId($id);
        $posti = new FPosti();
        $posti->store($proiezione);
    }

    public function load($value,$row,$puntuale,$inizio,$fine): array {
        $db = FDatabase::getInstance();
        if($puntuale === true) {
            $result = $db->loadFromDB($this->getClassName(),$value,$row);
        }
        else {
            $result = $db->loadBetweenProiezione($inizio,$fine);
        }
        if($result === null) {
            $result = [];
            array_push($result,null);
            return $result;
        }
        $return = array();
        for($i=0;$i<sizeof($result);$i++) {
           //DATI DELLA PROIEZIONE
           $id = $return[$i]["idFilm"];
           $nSala = intval($return[$i]["numerosala"]);
           $data = $return[$i]["data"];
           $ora = $return[$i]["ora"];
           //DATI DEL FILM
           $film = new FFilm();
           $film = $film->load('id',$id);
           $durata = DateInterval::createFromDateString($film["durata"]);
           $dataRilascio = $film["dataRilascio"];
           $dataRilascio = new DateTime($dataRilascio);
           $genere = $film["genere"];
           $genere = EGenere::$genere;
           //DATI DELLA SALAVIRTUALE
           $sala = new FSalaFisica();
           //COSTRUISCO L'OGGETTO SALAVIRTUALE
            $salaV = $sala->load($nSala);
           //COSTRUISCO L'OGGETTO FILM
           $film = new EFilm($id,$film["nome"],$film["descrizione"],$durata,$film["trailerURL"],$film["votoCritica"],$dataRilascio,$genere);
           //COSTRUSICO L'OGGETTO DATAORA
           $dataora = new DateTime($data . "T" . $ora);
           //AGGIUNGO LA PROIEZIONE ALLA LISTA DI RITORNO
           array_push($return,new EProiezione($film,$salaV,$dataora));
        }

        return $return;
    }

    public function update($value,$row,$newvalue,$newrow): bool {
        $db = FDatabase::getInstance();
        if($db->updateTheDB($this->getClassName(),$value,$row,$newvalue,$newrow)){
            return true;
        }
        return false;
    }

    public function delete($value,$row): bool {
        $db = FDatabase::getInstance();
        if($db->deleteFromDB($this->getClassName(),$value,$row)){
            return true;
        }
        return false;
    }


}