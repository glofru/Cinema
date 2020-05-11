<?php
/**
 * Nella classe Salamanager sono presenti attributi e metodi per la gestione di una sala
 * I suoi attributi sono i seguenti:
 * - sala: oggetto contenente la sala da gestire;
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class ESalamanager implements JsonSerializable
{
    /**
     * Sala da gestire
     * @AttributeType ESala
     */
    private ESala $sala;

    public function __construct(ESala $sala)
    {
        $this->sala = $sala;
    }

//-------------- SETTER ----------------------
    /**
     * @param ESala $sala sala da gestire
     */
    public function setSala(ESala $sala)
    {
        $this->sala = $sala;
    }

//----------------- GETTER --------------------
    /**
     * @return ESala la sala da gestire
     */
    public function getSala(): ESala
    {
        return $this->sala;
    }

//------------- ALTRI METODI ----------------
    /**
     * Controlla se un posto è presente realmente nella sala gestita
     * @param EPosto $posto posto che si vuole controllare
     * @return int indice del posto nell'array dei posti in sala
     */
    public function isValido(EPosto $posto): int
    {
        $result = array_search($this->sala . getPosti(), $posto);
        if ($result === "") {
            return -1;
        } else {
            return $result;
        }
    }
    /**
     * Controlla se un posto è libero in sala
     * @param EPosto $posto posto che si vuole controllare
     * @return string risultato del controllo
     */
    public function isPostolibero(EPosto $posto): string
    {
        $result = $this->isPostolibero($posto);
        if ($result === -1) {
            return "Posto non presnete in sala";
        }
        if ($this->sala . getPosti()[$result] . getOccupato()) {
            return "false";
        } else {
            return "true";
        }
    }
    /**
     * Controlla se un posto è occupato o meno in sala
     * @param EPosto $posto posto che si vuole controllare
     * @return string risultato del controllo
     */
    public function occupaPosto(EPosto $posto): bool
    {
        if ($this->isPostolibero($posto) == "true") {
            $result = array_search($posto, $this->sala.getPosti());
            $this->sala.getPosti()[$result].setOccupato(false);
        } else {
            return false;
        }
    }
    /**
     * Controlla se un posto è occupato in sala
     * @param EPosto $posto posto che si vuole controllare
     * @return bool risultato booleano del controllo
     */
    public function liberaPosto(EPosto $posto): bool
    {
        if ($this->isPostolibero($posto) === "false") {
            $result = array_search($posto, $this->sala.getPosti());
            $this->sala.getPosti()[$result].setOccupato(true);
        } else {
            return false;
        }
    }
    /**
     * Conta il numero dei posti liberi in sala
     * @return int numero dei posti liberi in sala
     */
    public function postiLiberi(): int{
        $count = 0;
        foreach ($this->sala.getPosti() as $elem){
            if($elem.getOccupato() === false){
                $count += 1;
            }
        }
        return $count;
    }
    /**
     * Conta il numero dei posti occupati in sala
     * @return int numero dei posti occupati in sala
     */
    public function postiOccupati(): int{
        return $this->sala.getNumeroPosti() - $this->postiLiberi();
    }

    public function jsonSerialize ()
    {
        return
            [
                'sala'   => $this->getSala(),
            ];
    }
}