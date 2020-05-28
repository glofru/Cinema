<?php
/**
 * Nella classe Sala sono i presenti attributi e metodi per la creazione e gestione dell'elenco delle programmazioni
 * I suoi attributi sono i seguenti:
 * - elencoProgrammazioni: array contenente l'insieme di tutte le programmazioni dei film da proiettare nel cinema
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */class EElencoProgrammazioni implements JsonSerializable
{
    /**
     * Insieme delle programmazioni da proiettare
     * @AttributeType array
     */
    private array $elencoProgrammazioni;

    public function __construct() {
        $this->elencoProgrammazioni = [];
    }

//-------------- SETTER ----------------------

//----------------- GETTER --------------------
    /**
     * @return array insieme delle programmazioni
     */
    public function getElencoProgrammazioni(): array {
        return $this->elencoProgrammazioni;
    }

//------------- ALTRI METODI ----------------
    /**
     * Aggiunge una programmazione all'insieme
     * @param EProgrammazionefilm $programmazione programmazione da aggiungere all'insieme
     */
    public function addProgrammazioneFilm(EProgrammazioneFilm $programmazione) {
        array_push($this->elencoProgrammazioni, $programmazione);
    }

    public function addProiezione(EProiezione $proiezione) {
        $programmazioneFilm = $this->getIfExistsProgrammazioneFilm($proiezione->getFilm());

        if ($programmazioneFilm != null) {
            $programmazioneFilm->addProiezione($proiezione);
        } else {
            $programmazioneFilm = new EProgrammazioneFilm();
            $programmazioneFilm->addProiezione($proiezione);
            $this->addProgrammazioneFilm($programmazioneFilm);
        }
    }

    public function getIfExistsProgrammazioneFilm(EFilm $film) {
        foreach ($this->elencoProgrammazioni as $programmazione) {
            if ($programmazione->getFilm()->getId() == $film->getId()) {
                return $programmazione;
            }
        }

        return null;
    }

    /**
     * Aggiunge una programmazione all'insieme
     * @param EProgrammazionefilm $programmazione programmazione da rimuovere dall'insieme
     * @return bool esito dell'operazione
     */
    public function rimuoviProgrammazione(EProgrammazioneFilm $programmazione): bool{
        $result = array_search($programmazione, $this->getElencoProgrammazioni());
        if($result !== ""){
            unset($this->getElencoProgrammazioni()[$result]);
            return true;
        }

        return false;
    }

    public function jsonSerialize ()
    {
        return
            [
                'elencoProgrammazioni'   => $this->getElencoProgrammazioni(),
            ];
    }
}