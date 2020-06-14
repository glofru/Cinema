<?php

/**
 * Classe che permette il salvataggio e il caricamento di oggetti EProiezione dal DB.
 * Class FProiezione
 * @author Lofrumento - Di Santo - Susanna
 * @package Foundation
 */
class FProiezione implements Foundation
{
    /**
     * Nome della classe.
     * @var string
     */
    private static string $className  = "FProiezione";

    /**
     * Nome della corrispondente tabella presente sul DB.
     * @var string
     */
    private static string $tableName  = "Proiezione";

    /**
     * Insieme delle colonne presenti nella tabella sul DB che verrà sostituita in fase di binding.
     * @var string
     */
    private static string $valuesName = "(:id,:data,:ora,:numerosala,:idFilm)";

    /**
     * FProiezione constructor.
     */
    public function __construct() {}

    /**
     * Funzione che esegue il binding fra i parametri ed i reali valori da assegnare per salvare l'oggetto.
     * @param PDOStatement $sender
     * @param $proiezione, oggetto dal quale si vogliono prelevare i valori.
     * @return mixed|void
     */
    public static function associate(PDOStatement $sender, $proiezione) {
        if ($proiezione instanceof EProiezione) {
            $sender->bindValue(':id',         NULL,                                            PDO::PARAM_INT);
            $sender->bindValue(':data',       $proiezione->getDataSQL(),                       PDO::PARAM_STR);
            $sender->bindValue(':ora',        $proiezione->getDataProiezione()->format("H:i"), PDO::PARAM_STR);
            $sender->bindValue(':numerosala', $proiezione->getSala()->getNumeroSala(),         PDO::PARAM_INT);
            $sender->bindValue(':idFilm',     $proiezione->getFilm()->getId(),                 PDO::PARAM_INT);
        } else {
            die("Not a projection!!");
        }
    }

    /**
     * Funzione che ritorna il nome della classe.
     * @return string
     */
    public static function getClassName() {
        return self::$className;
    }

    /**
     * Funzione che ritorna il nome della tabella presente sul DB.
     * @return string
     */
    public static function getTableName() {
        return self::$tableName;
    }

    /**
     * Funzione che ritorna i valori delle colonne della tabella per il binding.
     * @return string
     */
    public static function getValuesName() {
        return self::$valuesName;
    }

//------------- ALTRI METODI ----------------

    /**
     * Funzione che permette di salvare una proiezione sul DB. Prima di inserirla controlla se non si sovrapponga con un'altra già esistente sul DB.
     * @param EProiezione $proiezione, proiezione da salvare.
     * @return bool, esito dell'operazione.
     */
    public static function save(EProiezione $proiezione): bool {
        $db          = FDatabase::getInstance();

        $sovrapposto = self::isSovrapposto($proiezione);

        if (!$sovrapposto) {
            $db->saveToDBProiezioneEPosti($proiezione);

            return true;
        }

        return false;
    }

    /**
     * Funzione che controlla se una proieizone che si vuole inserire nel DB si sovrapponga ad una già esistente. Permette, quindi, di mantenere consistente la base dati. Ritorna un booleano con l'esito.
     * @param EProiezione $proiezione
     * @return bool
     */
    public static function isSovrapposto(EProiezione $proiezione): bool {
        $proIn      = $proiezione->getDataProiezione();
        $proFin     = (clone $proIn)->add($proiezione->getFilm()->getDurata());

        $elencoProg = self::parseResult(FDatabase::getInstance()->isSovrappostaProiezione($proiezione));

        foreach ($elencoProg->getElencoProgrammazioni() as $prog) {
            foreach ($prog->getProiezioni() as $p) {
                $inizio = $p->getDataProiezione();
                $fine   = $p->getDataProiezione()->add($p->getFilm()->getDurata());

                if (($inizio->getTimestamp() >= $proIn->getTimestamp() && $inizio->getTimestamp() <= $proFin->getTimestamp()) ||
                    ($fine->getTImestamp()    > $proIn->getTimestamp() && $fine->getTimestamp()    < $proFin->getTimestamp()) ||
                    ($inizio->getTimestamp()  < $proIn->getTimestamp() && $fine->getTimestamp()    > $proFin->getTimestamp())) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Funzione che permette di caricare una proiezione dal DB. Si appoggia alla funzione parseResult per ottenere come risultato un EElencoProgrammazioni.
     * @param string $value, valore necessario ad indetificare l'oggetto.
     * @param string $row, colonna nella quale cercare il valore.
     * @return EElencoProgrammazioni, oggetto EElencoProgrammazioni.
     */
    public static function load($value, $row): EElencoProgrammazioni {
        $db     = FDatabase::getInstance();

        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        return self::parseResult($result);
    }

    /**
     * Funzione che permette di caricare tutte le proiezioni dal DB. Si appoggia alla funzione parseResult per ottenere come risultato un EElencoProgrammazioni.
     * @return EElencoProgrammazioni, oggetto EElencoProgrammazioni.
     */
    public static function loadAll(): EElencoProgrammazioni {
        $db     = FDatabase::getInstance();

        $result = $db->loadByDate(self::getClassName(), new DateTime());

        return self::parseResult($result);
    }

    /**
     * Funzione che permette di caricare un insieme di proiezioni a partire da un intervallo di date. Si appoggia alla funzione parseResult per ottenere come risultato un EElencoProgrammazioni.
     * @param $inizio, data di inizio.
     * @param $fine, data di fine.
     * @return EElencoProgrammazioni, oggetto EElencoProgrammazioni.
     */
    public static function loadBetween($inizio, $fine): EElencoProgrammazioni {
        $db = FDatabase::getInstance();

        $result = $db->loadBetween(self::getClassName(), $inizio, $fine, "data");

        return self::parseResult($result);
    }

    /**
     * Funzione che permette di aggiornare un oggetto proiezione nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indetificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @param $newvalue, valore che si vuole inserire.
     * @param $newrow, colonna nella quale inserire il nuovo valore.
     * @return bool, esito dell'operazione.
     */
    public static function update($value, $row, $newvalue, $newrow): bool {
        $db = FDatabase::getInstance();

        return $db->updateTheDB(self::getClassName(), $value, $row, $newvalue, $newrow);
    }

    /**
     * Funzione che elimina un oggetto nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indetificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @return bool, esito dell'operazione.
     */
    public static function delete($value, $row): bool {
        $db = FDatabase::getInstance();

        return $db->deleteFromDB(self::getClassName(), $value, $row);
    }

    /**
     * Funzione che permette, dato un array di biglietti, di salvare i biglietti ed occupare i posti relativi. Ritorna il risultato dell'operazione.
     * @param array $biglietti, array di biglietti usati per occupare i posti della proiezione.
     * @return bool|mixed|null, esito dell'operazione.
     */
    public static function occupaPosti(array $biglietti) {
        $db = FDatabase::getInstance();

        return $db->occupaPosti($biglietti);
    }

    /**
     * Funzione che, sfruttando la parseProiezione, aggiunge all'ElencoProgrammazioni nel corrispettivo ProgrammazioneFilm la proiezione caricata.
     * @param array $result, riga del database che si vuole 'parsare'.
     * @return EElencoProgrammazioni, oggetto EElencoProgrammazioni.
     */
    private static function parseResult(array $result): EElencoProgrammazioni {
        $elencoProgrammazioni = new EElencoProgrammazioni();

        foreach ($result as $row) {
            $elencoProgrammazioni->addProiezione(self::parseProiezione($row));
        }

        return $elencoProgrammazioni;
    }

    /**
     * Funzione che, dato un array di righe ritornate dal DB, permette di ricostruire oggetti della classe Eproiezione.
     * @param $row, riga del database che si vuole 'parsare'.
     * @return EProiezione, oggetto EProiezione.
     */
    private static function parseProiezione($row): EProiezione {
        $id     = $row["id"];
        $data   = $row["data"];
        $ora    = $row["ora"];

        //OTTENGO L'OGGETTO FILM
        $film   = FFilm::load($row["idFilm"], "id")[0];

        //COSTRUISCO L'OGGETTO SALAVIRTUALE
        $sala   = FSala::loadVirtuale($row["numerosala"], "nSala")[0];
        $posti  = FPosto::load($id, "idProiezione");

        foreach($posti as $posto) {
            if ($posto->isOccupato()) {
                $sala->occupaPosto($posto);
            }
        }

        //COSTRUSICO L'OGGETTO DATAORA
        try {
            $dataora = new DateTime($data . "T" . $ora);
        } catch (Exception $e) {
            $dataora = time();
        }

        //AGGIUNGO LA PROIEZIONE ALLA LISTA DI RITORNO
        $proiezione  = new EProiezione($film, $sala, $dataora);
        $proiezione->setId($id);

        return $proiezione;
    }
}
