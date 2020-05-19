<?php


class FFilm
{
    private static string $className = "FFilm";
    private static string $tableName = "Film";
    private static string $valuesName = "(:idFilm,:nome,:descrizione,:durata,:trailerURL,:votoCritica,:dataDiRilascio,:genere,:attori,:registi)";

    public function __construct() {}

    public function associate(PDOStatement $sender, EFilm $film) {
        $sender->bindValue(':idFilm', $film->getId(), PDO::PARAM_INT);
        $sender->bindValue(':nome', $film->getNome(), PDO::PARAM_STR);
        $sender->bindValue(':descrizione',$film->getDescrizione(),PDO::PARAM_STR);
        $sender->bindValue(':durata',$film->getDurata()->format("H:i"),PDO::PARAM_STR);
        $sender->bindValue(':trailerURL', $film->getTrailerURL(), PDO::PARAM_STR);
        $sender->bindValue(':votoCritica', $film->getVotoCritica(), PDO::PARAM_STR);
        $sender->bindValue(':dataRilascio', $film->getDataRilascio()->format("Y-m-d"), PDO::PARAM_STR);
        $sender->bindValue(':genere', $film->getGenere(), PDO::PARAM_STR);
        $sender->bindValue(':attori', self::splitArray($film->getAttori()), PDO::PARAM_STR);
        $sender->bindValue(':registi', self::splitArray($film->getRegisti()), PDO::PARAM_STR);
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
            array_push($return, FPersona::load($e, "idPersona"));
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

    public static function save(EFilm $film) {
        $db = FDatabase::getInstance();
        $db->saveToDB(self::getClassName(), $film);
    }

    public static function load (string $value, string $row): array {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        if($result === null) {
            return [];
        }

        $return = array();
        for($i = 0; $i < sizeof($result); $i++)
        {
            $row = $result[$i];
            $id = $row["idFilm"];
            $nome = $row["nome"];
            $descrizione = $row["descrizione"];
            $durata = DateInterval::createFromDateString($row["durata"]);
            $trailerURL = $row["trailerURL"];
            $votoCritica = floatval($row["votoCritica"]);
            $dataRilascio = DateTime::createFromFormat("Y-m-d", $row["dataRilascio"]);
            $genere = EGenere::fromString($row["genere"]);
            $film = new EFilm($id, $nome, $descrizione, $durata, $trailerURL, $votoCritica, $dataRilascio, $genere);
            foreach (self::recreateArray($row["attori"]) as $attore)
            {
                $film->addAttore($attore);
            }
            foreach (self::recreateArray($row["registi"]) as $regista)
            {
                $film->addRegista($regista);
            }

            array_push($return, $film);
        }

        return $return;
    }


}