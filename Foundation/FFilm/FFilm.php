<?php


class FFilm implements Foundation
{
    private static string $className = "FFilm";
    private static string $tableName = "Film";
    private static string $valuesName = "(:id,:nome,:descrizione,:durata,:trailerURL,:votoCritica,:dataRilascio,:genere,:attori,:registi,:paese,:etaConsigliata)";

    public function __construct() {}

    public static function associate(PDOStatement $sender, $film) {
        if ($film instanceof EFilm) {
            $sender->bindValue(':id', NULL, PDO::PARAM_INT);
            $sender->bindValue(':nome', $film->getNome(), PDO::PARAM_STR);
            $sender->bindValue(':descrizione', $film->getDescrizione(), PDO::PARAM_STR);
            $sender->bindValue(':durata', $film->getDurataString(), PDO::PARAM_STR);
            $sender->bindValue(':trailerURL', $film->getTrailerURL(), PDO::PARAM_STR);
            $sender->bindValue(':votoCritica', $film->getVotoCritica(), PDO::PARAM_STR);
            $sender->bindValue(':dataRilascio', $film->getdataRilascioSQL(), PDO::PARAM_STR);
            $sender->bindValue(':genere', $film->getGenere(), PDO::PARAM_STR);
            $sender->bindValue(':attori', self::splitArray($film->getAttori()), PDO::PARAM_STR);
            $sender->bindValue(':registi', self::splitArray($film->getRegisti()), PDO::PARAM_STR);
            $sender->bindValue(':paese', $film->getPaese(), PDO::PARAM_STR);
            $sender->bindValue(':etaConsigliata', $film->getPaese(), PDO::PARAM_STR);
        } else {
            die("Not a film!!");
        }
    }

    private static function splitArray(array $a): string
    {
        $s = "";
        foreach ($a as $value)
        {
            $s .= $value->getId() . ";";
        }
        $s[strlen($s)-1] = "";
        return $s;
    }

    private static function recreateArray(string $s): array
    {
        $return = [];
        $temp = explode(";", $s);

        foreach ($temp as $e)
        {
            array_push($return, FPersona::load($e, "id"));
        }

        return $return;
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

    public static function save(EFilm $film)
    {
        $db = FDatabase::getInstance();
        $id = $db->saveToDB(self::getClassName(), $film);
        $film->setId($id);
    }

    public static function load (string $value, string $row): array
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        return self::parseResult($result);
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

    public static function delete($value, $row): bool
    {
        $db = FDatabase::getInstance();
        if($db->deleteFromDB(self::getClassName(), $value, $row)){
            return true;
        }
        return false;
    }

    public static function ricercaPerData(string $dataInizio, string $dataFine)
    {
        $db = FDatabase::getInstance();
        $result = $db->loadBetween(self::getClassName(), $dataInizio, $dataFine, "dataRilascio");

        if ($result == null || sizeof($result) == 0)
        {
            return [];
        }

        return self::parseResult($result);
    }

    public static function ricercaPerGenere(EGenere $genere)
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $genere, "genere");

        if ($result == null || sizeof($result) == 0)
        {
            return [];
        }

        return self::parseResult($result);
    }

    public static function ricercaperNome(string $nome) {
        $db = FDatabase::getInstance();
        $result = $db->loadLike(self::getClassName(), $nome, "nome");
        if ($result == null || sizeof($result) == 0)
        {
            return [];
        }

        return self::parseResult($result);
    }

    private static function parseResult(array $result): array
    {
        $return = array();

        foreach ($result as $row)
        {
            $id = $row["id"];
            $nome = $row["nome"];
            $descrizione = $row["descrizione"];
            $durata = explode(':',$row["durata"]);
            try {
                $durata = new DateInterval ("PT" . $durata[0] . "H" . $durata[1] . "M");
            } catch (Exception $e) {
                $durata = null;
            }
            $trailerURL = $row["trailerURL"];
            $votoCritica = floatval($row["votoCritica"]);
            $dataRilascio = DateTime::createFromFormat("Y-m-d", $row["dataRilascio"]);
            $genere = EGenere::fromString($row["genere"]);
            $paese = $row["paese"];
            $etaConsigliata = $row["etaConsigliata"];
            $film = new EFilm($nome, $descrizione, $durata, $trailerURL, $votoCritica, $dataRilascio, $genere, $paese, $etaConsigliata);
            $film->setId($id);
            /*foreach (self::recreateArray($row["attori"]) as $attore)
            {
                $film->addAttore($attore);
            }
            foreach (self::recreateArray($row["registi"]) as $regista)
            {
                $film->addRegista($regista);
            }*/

            array_push($return, $film);
        }

        return $return;
    }
}