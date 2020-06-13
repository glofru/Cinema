<?php

/**
 * Nella classe posto sono contenuti attributi e metodo necessari alla creazione e gestione del singolo posto presente in una sala del cinema.
 * Class EPosto
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EPosto implements JsonSerializable
{
    /**
     * lettera assegnata alla specifica fila.
     * @AttributeType string
     */
    private string $fila;
    /**
     * Numero progressivo che identifica i posti all'interno di una fila.
     * @AttributeType int
     */
    private int $numeroPosto;
    /**
     * Attributo che identifica la disponibilità di un determinato posto.
     * @AttributeType bool
     */
    private bool $occupato;

    /**
     * EPosto constructor.
     * @param string $fila, fila alla quale appartiene il posto.
     * @param int $numeroPosto, numero del posto.
     * @param bool $occupato, se il posto sia occupato o meno.
     */
    public function __construct(string $fila, int $numeroPosto, bool $occupato = false) {
        $this->setFila($fila);
        $this->setNumeroPosto($numeroPosto);
        $this->setIsOccupato($occupato);
    }

    /**
     * Funzione che data una stringa codificata (fila;posto;fila;posto...) e la disponibilità dei posti effettua parsing della stringa e restituisce i posti associati.
     * @param string $posto, stringa codificata contente le informazioni sul posto.
     * @param bool $occupato, se il posto sia occupato o meno.
     * @return array, insieme dei posti risultanti.
     */
    public static function fromString(string $posto, bool $occupato): array {
        $posti = [];
        $lock = explode(";", $posto);
        foreach ($lock as $elem) {
            array_push($posti, self::fromDB($elem, $occupato));
        }
        return $posti;
    }

    /**
     * Funzione che, dato un posto salvato nel DB, effettua il parsing della stringa passata ed insieme alla relativa disponibilità restituisce un posto.
     * @param string $posto, stringa reperita dal DB.
     * @param bool $occupato, identifica se il posto sia occupato.
     * @return EPosto, posto risultante.
     */
    public static function fromDB(string $posto, bool $occupato): EPosto {
        $elem = explode("_", $posto);
        return new EPosto($elem[0], $elem[1], $occupato);

    }
//-------------- SETTER ----------------------
    /**
     * @param string $fila, lettera assegnata alla fila.
     */
    public function setFila(string $fila){
        $this->fila = $fila;
    }
    /**
     * @param int $numeroPosto, numero assegnato al numeroposto.
     */
    public function setNumeroPosto(int $numeroPosto){
        $this->numeroPosto = $numeroPosto;
    }
    /**
     * @param bool $occupato, disponibilità del numeroposto.
     */
    public function setIsOccupato(bool $occupato){
        $this->occupato = $occupato;
    }

//----------------- GETTER --------------------
    /**
     * @return string, fila nella quale si trova il numeroposto.
     */
    public function getFila(): string {
        return $this->fila;
    }
    /**
     * @return int, numero di numeroposto.
     */
    public function getNumeroPosto(): int{
        return $this->numeroPosto;
    }
    /**
     * @return bool, disponibilità del numeroposto.
     */
    public function isOccupato(): bool{
        return $this->occupato;
    }

    /**
     * Funzione che permette di controllare se un posto sia uguale ad un altro posto passato come parametro.
     * @param EPosto $posto, posto che si vuole confrontare.
     * @return bool, esito del confronto.
     */
    public function isEqual(EPosto $posto): bool {
        return $this->getFila() == $posto->getFila() && $this->getNumeroPosto() == $posto->getNumeroPosto();
    }

    /**
     * Funzione che ritorna l'identificativo del posto (NFILA_NPOSTO) al fine di poterlo inserire nel database.
     * @return string, stringa parsata.
     */
    public function getId(): string {
        return $this->getFila() . "_" . $this->getNumeroPosto();
    }

//------------- ALTRI METODI ----------------

    /**
     * @return array|mixed, funzione che serializza il contenuto della classe in formato JSON, necessario per rendere l'applicazione RESTFULL.
     */
    public function jsonSerialize ()
    {
        return
            [
                'fila'   => $this->getFila(),
                'numeroposto' => $this->getNumeroPosto(),
                'occupato'   => $this->isOccupato(),
            ];
    }
    /**
     * @return string
     */
    public function __toString(): string
    {
        return " Fila: " .$this->getFila() . " Posto: " . strval($this->getNumeroPosto());
    }

}