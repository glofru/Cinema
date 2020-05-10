<?php

/**
 * Nella classe Posto sono contenuti attributi e metodo necessari alla creazione e gestione del singolo posto presente in una sala del cinema
 * I suoi attributi sono i seguenti:
 * - fila: lettera necessaria ad individuare la fila nella quale si trova il posto;
 * - posto: valore numercio che indica il numero di posto all'interno di una fila;
 * - occupato: booleano necessario ad individuare quale posto sia stato già acquistato e quale sia libero;
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
    private int $posto;
    /**
     * Attributo che identifica la disponibilità di un determinato posto
     * @AttributeType bool
     */
    private bool $occupato;

    public function __construct(string $fila, int $posto){
        $this->fila = $fila;
        $this->posto = $posto;
        $this->occupato = false;
}
//-------------- SETTER ----------------------
    /**
     * @param string $fila lettera assegnata alla fila
     */
    public function setFila(string $fila){
        $this->fila = $fila;
    }
    /**
     * @param int $posto numero assegnato al posto
     */
    public function setPosto(int $posto){
        $this->posto = $posto;
    }
    /**
     * @param bool $occupato disponibilità del posto
     */
    public function setOccupato(bool $occupato){
        $this->occupato = $occupato;
    }

//----------------- GETTER --------------------
    /**
     * @return string fila nella quale si trova il posto
     */
    public function getFila(): string {
        return $this->fila;
    }
    /**
     * @return int numero di posto
     */
    public function getPosto(): int{
        return $this->posto;
    }
    /**
     * @return bool disponibilità del posto
     */
    public function getOccupato(): bool{
        return $this->occupato;
    }

//------------- ALTRI METODI ----------------

    public function jsonSerialize ()
    {
        return
            [
                'fila'   => $this->getFila(),
                'posto' => $this->getPosto(),
                'occupato'   => $this->getOccupato(),
            ];
    }
    /**
     * @return string
     */
    public function __toString()
    {
        if($this->getOccupato() == true){
            $status = "libero";
        }
        else{
            $status = "occupato";
        }
        return "Il posto " . strval($this->getPosto()) . " nella fila " . $this->getFila() . "è " . $status;
    }
}