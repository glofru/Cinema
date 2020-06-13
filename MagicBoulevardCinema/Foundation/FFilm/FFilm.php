<?php

/**
 * Classe che permette il salvataggio sul DB di oggetti EFilm.
 * Class FFilm
 * @author Lofrumento - Di Santo - Susanna
 * @package Foundation
 */
class FFilm implements Foundation
{
    /**
     * Nome della classe.
     * @var string
     */
    private static string $className = "FFilm";
    /**
     * Nome della corrispondente tabella presente sul DB.
     * @var string
     */
    private static string $tableName = "Film";
    /**
     * Insieme delle colonne presenti nella tabella sul DB che verrà sostituita in fase di binding.
     * @var string
     */
    private static string $valuesName = "(:id,:nome,:descrizione,:durata,:trailerURL,:votoCritica,:dataRilascio,:genere,:attori,:registi,:paese,:etaConsigliata)";

    /**
     * FFilm constructor.
     */
    public function __construct() {}

    /**
     * Funzione che esegue il binding fra i parametri ed i reali valori da assegnare per salvare l'oggetto.
     * @param PDOStatement $sender
     * @param $film, oggetto dal quale si vogliono prelevare i valori.
     * @return mixed|void
     */
    public static function associate(PDOStatement $sender, $film) {
        if ($film instanceof EFilm) {
            $sender->bindValue(':id',               NULL,                             PDO::PARAM_INT);
            $sender->bindValue(':nome',             $film->getNome(),                       PDO::PARAM_STR);
            $sender->bindValue(':descrizione',      $film->getDescrizione(),                PDO::PARAM_STR);
            $sender->bindValue(':durata',           $film->getDurataString(),               PDO::PARAM_STR);
            $sender->bindValue(':trailerURL',       $film->getTrailerURL(),                 PDO::PARAM_STR);
            $sender->bindValue(':votoCritica',      $film->getVotoCritica(),                PDO::PARAM_STR);
            $sender->bindValue(':dataRilascio',     $film->getdataRilascioSQL(),            PDO::PARAM_STR);
            $sender->bindValue(':genere',           $film->getGenere(),                     PDO::PARAM_STR);
            $sender->bindValue(':attori',           self::splitArray($film->getAttori()),   PDO::PARAM_STR);
            $sender->bindValue(':registi',          self::splitArray($film->getRegisti()),  PDO::PARAM_STR);
            $sender->bindValue(':paese',            $film->getPaese(),                      PDO::PARAM_STR);
            $sender->bindValue(':etaConsigliata',   $film->getEtaConsigliata(),             PDO::PARAM_STR);
        } else {
            die("Not a film!!");
        }
    }

    /**
     * Funzione ausiliaria che permette di ottenere da un array di attori o registi una stringa in forma consona per essere inserita nel DB.
     * @param array $a, array di attori o registi.
     * @return string, stringa contente gli id degli attori o registi partecipanti al film sepratai da ';'.
     */
    private static function splitArray(array $a): string
    {
        $s = "";

        foreach ($a as $value) {
            $s .= $value->getId() . ";";
        }

        $s = substr($s, 0, -1);
        return $s;
    }

    /**
     * Funzione inversa allo splitArray che permette di riscostruire un array da una stringa di attori o registi
     * @param string $s, stringa contente gli id degli attori o registi partecipanti al film sepratai da ';'.
     * @return array, array di attori o registi.
     */
    public static function recreateArray(string $s): array
    {
        $return = [];

        if ($s == "") return $return;

        $temp = explode(";", $s);
        foreach ($temp as $e) {
            $pers = FPersona::load($e, "id");
            $p = null;
            if (sizeof($pers) > 0) {
                $p = $pers[0];
            }
            array_push($return, $p);
        }

        return $return;
    }

    /**
     * Funzione che ritorna il nome della classe.
     * @return string
     */
    public static function getClassName()
    {
        return self::$className;
    }

    /**
     * Funzione che ritorna il nome della tabella presente sul DB.
     * @return string
     */
    public static function getTableName()
    {
        return self::$tableName;
    }

    /**
     * Funzione che ritorna i valori delle colonne della tabella per il binding.
     * @return string
     */
    public static function getValuesName()
    {
        return self::$valuesName;
    }

    /**
     * Funzione che permette di salvare un film sul DB.
     * @param EFilm $film, film da salvare.
     */
    public static function save(EFilm $film)
    {
        $db = FDatabase::getInstance();

        $id = $db->saveToDB(self::getClassName(), $film);

        $film->setId($id);
    }

    /**
     * Funzione che permette di caricare un film dal DB. Si appoggia alla funzione parseResult per ottenere come risultato un array di oggetti.
     * @param string $value, valore da usare per identificare l'oggetto.
     * @param string $row, colonna nella quale cercare il valore.
     * @return array, array di EFilm.
     */
    public static function load(string $value, string $row): array
    {
        $db = FDatabase::getInstance();

        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        return self::parseResult($result);
    }

    /**
     * Funzione che permette di caricare tutti i film presenti nel DB. Si appoggia alla funzione parseResult per ottenere come risultato un array di oggetti.
     * @return array, array con tutti gli EFilm nel database.
     */
    public static function loadAll(): array
    {
        $db = FDatabase::getInstance();

        $result = $db->loadAll(self::getClassName());

        return self::parseResult($result);
    }

    /**
     * Funzione che permette di caricare un insieme di film a partire da un intervallo di date. Si appoggia alla funzione parseResult per ottenere come risultato un array di oggetti.
     * @param $inizio, data di inizio.
     * @param $fine, data di fine.
     * @return array, array di EFilm.
     */
    public static function loadBetween($inizio,$fine) {
        $db = FDatabase::getInstance();

        $result = $db->loadBetween(self::getClassName(),$inizio,$fine,"dataRilascio");

        return self::parseResult($result);
    }

    /**
     * Funzione che permette di caricare un insieme di oggetti dal DB sulla base di una parola. Si appoggia alla funzione parseResult per ottenere come risultato un array di oggetti.
     * @param $value, valore da usare per identificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @return array, array di EFilm.
     */
    public static function loadLike($value, $row) {
        $db = FDatabase::getInstance();

        $result = $db->loadLike(self::getClassName(), $value, $row);

        return self::parseResult($result);
    }

    /**
     * Funzione che permette di aggiornare un oggetto film nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indetificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @param $newValue, valore che si vuole inserire.
     * @param $newRow, colonna nella quale inserire il nuovo valore.
     * @return bool, risultato dell'operazione.
     */
    public static function update($value, $row, $newValue, $newRow): bool
    {
        $db = FDatabase::getInstance();

        return $db->updateTheDB(self::getClassName(), $value, $row, $newValue, $newRow);
    }

    /**
     * Funzione che elimina un oggetto nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indetificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @return bool, risultato dell'operazione.
     */
    public static function delete($value, $row): bool
    {
        $db = FDatabase::getInstance();

        return $db->deleteFromDB(self::getClassName(), $value, $row);
    }

    /**
     * Funzione che permette di caricare un insieme di film a partire da un intervallo di date. Si appoggia alla funzione parseResult per ottenere come risultato un array di oggetti se vi è almeno un risultato sennò torna un array vuoto.
     * @param string $dataInizio, data di inzio.
     * @param string $dataFine, data di fine.
     * @return array, array di EFilm.
     */
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

    /**
     * Funzione che permette di caricare un insieme di film a partire da un particolare genere. Si appoggia alla funzione parseResult per ottenere come risultato un array di oggetti se vi è almeno un risultato sennò torna un array vuoto.
     * @param EGenere $genere, genere dei film che si sta cercando.
     * @return array, array di EFilm.
     */
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

    /**
     * Funzione che permette di caricare un insieme di film a partire da un nome. Si appoggia alla funzione parseResult per ottenere come risultato un array di oggetti se vi è almeno un risultato sennò torna un array vuoto.
     * @param string $nome, nome del film che si sta cercando.
     * @return array, array di EFilm.
     */
    public static function ricercaperNome(string $nome) {
        $db = FDatabase::getInstance();

        $result = $db->loadLike(self::getClassName(), $nome, "nome");
        if ($result == null || sizeof($result) == 0) {
            return [];
        }

        return self::parseResult($result);
    }

    /**
     * Funzione che permette di ottenere un film dal DB se questo rispetta determinati criteri passati come input. Si appoggia alla funzione parseResult per ottenere come risultato un array di oggetti.
     * @param $genere, genere del film.
     * @param float $votoInizio, voto minimo del film che si sta cercando.
     * @param float $votoFine, voto massimo del film che si sta cercando.
     * @param DateTime $annoInizio, anno minimo nel quale il film deve essere stato rilasciato.
     * @param DateTime $annoFine, anno massimo nel quale il film deve essere stato rilasciato.
     * @return array, array di EFilm.
     */
    public static function loadByFilter($genere, float $votoInizio, float $votoFine, DateTime $annoInizio, DateTime $annoFine) {
        $db = FDatabase::getInstance();

        $result = $db->loadByFilter(self::getClassName(), $genere, $votoInizio, $votoFine, $annoInizio->format("Y-m-d"), $annoFine->format("Y-m-d"));

        return self::parseResult($result);
    }

    /**
     * Funzione che, dato un array di righe ritornate dal DB, permette di ricostruire oggetti della classe EFilm ed inserirli un array da ritornare.
     * @param array $result, righe del database che si vuole 'parsare'.
     * @return array, array di EFilm.
     */
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