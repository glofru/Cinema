<?php
/**
 * Nella classe Sala sono i presenti attributi e metodi per la creazione e gestione della programmazione di un film
 * I suoi attributi sono i seguenti:
 * - film: film del quale si sta generando la relativa programmazione
 * - proiezioni: insieme delle proiezioni del film
 * - datainizio: data dalla quale inizierà ad essere messo in programmazione il film
 * - datafine: data dalla quale il film non sarà più in programmazione
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EProgrammazionefilm implements JsonSerializable
{
    /**
    * Film a cui appartiene la programmazione
    * @AttributeType EFilm
    */
    private EFilm $film;
    /**
     * Insieme delle proiezioni del film
     * @AttributeType array
     */
    private array $proiezioni;
    /**
     * Data di inzio delle proiezioni
     * @AttributeType Date
     */
    private Date $datainizio;
    /**
     * Data di fine delle proiezioni
     * @AttributeType Date
     */
    private Date $datafine;

    public function __construct(EFilm $film, array $proiezioni, Date $datainizio, Date $datafine){
        $this->film = $film;
        $this->proiezioni = $proiezioni;
        $this->datainizio = $datainizio;
        $this->datafine = $datafine;
    }

//-------------- SETTER ----------------------
    /**
     * @param EFilm $film film per il quale si vuole creare una programmazione
     */
    public function setFilm(EFilm $film){
        $this->film = $film;
    }
    /**
     * @param array $proiezioni insieme delle proiezioni che verranno proposte
     */
    public function setProiezioni(array $proiezioni){
        $this->proiezioni = $proiezioni;
    }
    /**
     * @param Date $datainizio data di inizio delle proeizioni del film
     */
    public function setDatainizio(Date $datainizio){
        $this->datainizio = $datainizio;
    }

    /**
     * @param Date $datafine data a partire dalla quale il film non sarà più in proiezione
     */
    public function setDatafine(Date $datafine){
        $this->datafine = $datafine;
    }

//----------------- GETTER --------------------
    /**
     * @return EFilm film di cui si sta creando la programmazione
     */
    public function getFilm(): EFilm{
        return $this->film;
    }
    /**
     * @return array insieme delle proiezioni del film
     */
    public function getProiezioni(): array {
        return $this->proiezioni;
    }
    /**
     * @return Date data di inizio delle proiezioni del film
     */
    public function getDatainizio(): Date {
        return $this->datainizio;
    }
    /**
     * @return Date data di fine delle proiezioni del film
     */
    public function getDatafine(): Date {
        return $this->datafine;
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
    public function jsonSerialize ()
    {
        return
            [
                'film'   => $this->getFilm(),
                'proiezioni' => $this->getProiezioni(),
                'datainizio'   => $this->getDatainizio(),
                'datafine'   => $this->getDatafine(),
            ];
    }

}