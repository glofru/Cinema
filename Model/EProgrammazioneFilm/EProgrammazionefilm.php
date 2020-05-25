<?php
/**
 * Nella classe Sala sono i presenti attributi e metodi per la creazione e gestione della programmazione di un film
 * I suoi attributi sono i seguenti:
 * - proiezioni: insieme delle proiezioni del film
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EProgrammazionefilm implements JsonSerializable
{
    /**
     * Insieme delle proiezioni del film
     * @AttributeType array
     */
    private array $proiezioni;

    private $film;


    public function __construct(){
        $this->proiezioni = array();
    }

//-------------- SETTER ----------------------
    public function add(EProiezione $proiezione){
        $temp = $proiezione;
        array_push($this->proiezioni, $temp);
        if($this->film === NULL){
            $this->film = $proiezione->getFilm();
        }
    }

//----------------- GETTER --------------------
    /**
     * @return array insieme delle proiezioni del film
     */
    public function getProiezioni(): array {
        return $this->proiezioni;
    }

    public function getFilm(): EFilm {
        return $this->film;
    }

//------------- ALTRI METODI ----------------
    /**
     * Aggiunge una proiezione all'insieme
     * @param EProiezione $proiezione proiezione da aggiungere all'insieme
     */
    public function aggiungiProiezione(EProiezione $proiezione){
        array_push($this->getProiezioni(), $proiezione);
    }
    /**
     * Rimuove una proiezione dall'insieme
     * @param EProiezione $proiezione proiezione da rimuovere dall'insieme
     * @return bool valore che indica il successo dell'operazione
     */
    public function rimuoviProiezione(EProiezione $proiezione): bool{
        $result = array_search($proiezione,$this->getProiezioni());
        if($result !== ""){
            unset($this->getProiezioni()[$result]);
            return true;
        }
        else{
            return false;
        }
    }

    public function clear() {
        unset ($this->proiezioni);
        $this->proiezioni = array();
    }
    public function jsonSerialize ()
    {
        return
            [
                'proiezioni' => $this->getProiezioni()
            ];
    }

}