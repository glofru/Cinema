<?php

/**
 * Nella classe posto sono contenuti attributi e metodo necessari alla creazione e gestione del singolo numeroposto presente in una sala del cinema
 * I suoi attributi sono i seguenti:
 * - fila: lettera necessaria ad individuare la fila nella quale si trova il numeroposto;
 * - numeroposto: valore numercio che indica il numero di numeroposto all'interno di una fila;
 * - occupato: booleano necessario ad individuare quale numeroposto sia stato già acquistato e quale sia libero;
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EPosto implements JsonSerializable
{
    /**
     * lettera assegnata alla specifica fila
     * @AttributeType string
     */
    private string $fila;
    /**
     * Numero progressivo che identifica i posti all'interno di una fila
     * @AttributeType int
     */
    private int $numeroPosto;
    /**
     * Attributo che identifica la disponibilità di un determinato numeroposto
     * @AttributeType bool
     */
    private bool $occupato;

    /**
     * EPosto constructor.
     * @param string $fila
     * @param int $numeroPosto
     * @param bool $occupato
     */
    public function __construct(string $fila, int $numeroPosto, bool $occupato = false)
    {
        $this->setFila($fila);
        $this->setNumeroPosto($numeroPosto);
        $this->setIsOccupato($occupato);
    }

    public static function fromString(string $posto, bool $libero) {
        $elem = explode(" ",$posto);
        return new EPosto($elem[0], intval($elem[1]), $libero);
    }
//-------------- SETTER ----------------------
    /**
     * @param string $fila lettera assegnata alla fila
     */
    public function setFila(string $fila){
        $this->fila = $fila;
    }
    /**
     * @param int $numeroPosto numero assegnato al numeroposto
     */
    public function setNumeroPosto(int $numeroPosto){
        $this->numeroPosto = $numeroPosto;
    }
    /**
     * @param bool $occupato disponibilità del numeroposto
     */
    public function setIsOccupato(bool $occupato){
        $this->occupato = $occupato;
    }

//----------------- GETTER --------------------
    /**
     * @return string fila nella quale si trova il numeroposto
     */
    public function getFila(): string {
        return $this->fila;
    }
    /**
     * @return int numero di numeroposto
     */
    public function getNumeroPosto(): int{
        return $this->numeroPosto;
    }
    /**
     * @return bool disponibilità del numeroposto
     */
    public function isOccupato(): bool{
        return $this->occupato;
    }

    public function isEqual(EPosto $posto): bool {
        return $this->getFila() == $posto->getFila() && $this->getNumeroPosto() == $posto->getNumeroPosto();
    }

//------------- ALTRI METODI ----------------

    /**
     * @return array|mixed
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
    public function __toString()
    {
        return $this->getFila() . strval($this->getNumeroPosto());
    }
}