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
class Enumeroposto implements JsonSerializable
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
    private int $numeroposto;
    /**
     * Attributo che identifica la disponibilità di un determinato numeroposto
     * @AttributeType bool
     */
    private bool $occupato;

    public function __construct(string $fila, int $numeroposto){
        $this->fila = $fila;
        $this->numeroposto = $numeroposto;
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
     * @param int $numeroposto numero assegnato al numeroposto
     */
    public function setnumeroposto(int $numeroposto){
        $this->numeroposto = $numeroposto;
    }
    /**
     * @param bool $occupato disponibilità del numeroposto
     */
    public function setOccupato(bool $occupato){
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
    public function getnumeroposto(): int{
        return $this->numeroposto;
    }
    /**
     * @return bool disponibilità del numeroposto
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
                'numeroposto' => $this->getnumeroposto(),
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
        return "Il numeroposto " . strval($this->getnumeroposto()) . " nella fila " . $this->getFila() . "è " . $status;
    }
}