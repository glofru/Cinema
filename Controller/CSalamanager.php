<?php
/**
 * Nella classe Salamanager sono presenti attributi e metodi per la gestione di una sala
 * I suoi attributi sono i seguenti:
 * - sala: oggetto contenente la sala da gestire;
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Controller
 */
class CSalamanager implements JsonSerializable
{
    /**
     * Sala da gestire
     * @AttributeType ESalaVirtuale
     */
    private ESalaVirtuale $sala;

    public function __construct(ESalaVirtuale $sala)
    {
        $this->setSala($sala);
    }

//-------------- SETTER ----------------------
    /**
     * @param ESalaVirtuale $sala sala da gestire
     */
    public function setSala(ESalaVirtuale $sala)
    {
        $this->sala = $sala;
    }

//----------------- GETTER --------------------
    /**
     * @return ESalaVirtuale la sala da gestire
     */
    public function getSala(): ESalaVirtuale
    {
        return $this->sala;
    }

//------------- ALTRI METODI ----------------
    /**
     * Controlla se un posto è presente realmente nella sala gestita
     * @param EPosto $posto posto che si vuole controllare
     * @return int indice del posto nell'array dei posti in sala
     */
    public function esiste(EPosto $posto): int
    {
        return $this->sala->esiste($posto);
    }

    /**
     * Controlla se un posto è libero in sala
     * @param EPosto $posto posto che si vuole controllare
     * @return string risultato del controllo
     */
    public function isPostolibero(EPosto $posto)
    {
        return $this->sala->isPostolibero($posto);
    }
    /**
     * Controlla se un posto è occupato o meno in sala
     * @param EPosto $posto posto che si vuole controllare
     * @return string risultato del controllo
     */
    public function occupaPosto(EPosto $posto): bool
    {
        return $this->sala->occupaPosto($posto);
    }
    /**
     * Controlla se un posto è occupato in sala
     * @param EPosto $posto posto che si vuole controllare
     * @return bool risultato booleano del controllo
     */
    public function liberaPosto(EPosto $posto): bool
    {
        return $this->sala->liberaPosto($posto);
    }
    /**
     * Conta il numero dei posti liberi in sala
     * @return int numero dei posti liberi in sala
     */
    public function getPostiLiberi(): int{
        return $this->sala->getNumeroPostiLiberi();
    }
    /**
     * Conta il numero dei posti occupati in sala
     * @return int numero dei posti occupati in sala
     */
    public function getPostiOccupati(): int{
        return $this->sala->getPo
    }

    public function jsonSerialize ()
    {
        return
            [
                'sala'   => $this->getSala(),
            ];
    }
}