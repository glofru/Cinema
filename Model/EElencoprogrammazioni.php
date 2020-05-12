<?php
/**
 * Nella classe Sala sono i presenti attributi e metodi per la creazione e gestione dell'elenco delle programmazioni
 * I suoi attributi sono i seguenti:
 * - elencoprogrammazioni: array contenente l'insieme di tutte le programmazioni dei film da proiettare nel cinema
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */class EElencoprogrammazioni implements JsonSerializable
{
    /**
     * Insieme delle programmazioni da proiettare
     * @AttributeType array
     */
    private array $elencoprogrammazioni;

    public function __construct() {
        $this->elencoprogrammazioni = [];
    }

//-------------- SETTER ----------------------

//----------------- GETTER --------------------
    /**
     * @return array insieme delle programmazioni
     */
    public function getElencoprogrammazioni(): array {
        return $this->elencoprogrammazioni;
    }

//------------- ALTRI METODI ----------------
    /**
     * Aggiunge una programmazione all'insieme
     * @param EProgrammazionefilm $programmazione programmazione da aggiungere all'insieme
     */
    public function addProgrammazione(EProgrammazionefilm $programmazione){
        array_push($this->elencoprogrammazioni, $programmazione);
    }
    /**
     * Aggiunge una programmazione all'insieme
     * @param EProgrammazionefilm $programmazione programmazione da rimuovere dall'insieme
     * @return bool esito dell'operazione
     */
    public function rimuoviProgrammazione(EProgrammazionefilm $programmazione): bool{
        $result = array_search($programmazione,$this->getElencoprogrammazioni());
        if($result !== ""){
            unset($this->getElencoprogrammazioni()[$result]);
            return true;
        }
        else{
            return false;
        }
    }

    public function jsonSerialize ()
    {
        return
            [
                'elencoprogrammazioni'   => $this->getElencoprogrammazioni(),
            ];
    }
}