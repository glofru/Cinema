<?php
/**
 * Nella classe Sala sono i presenti attributi e metodi per gestire una proiezione
 * I suoi attributi sono i seguenti:
 * - film: oggetto contenente tutti i dettagli sul film in proiezione
 * - sala: oggetto contente la sala nel quale verrà effettuata la proiezione
 * - dataproiezione: attributo contente data ed orario della la proiezione
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EProiezione implements JsonSerializable
{
    /**
     * Film che verrà proiettato
     * @AttributeType EFilm
     */
    private EFilm $film;
    /**
     * Sala nella quale verrà proiettato il film
     * @AttributeType ESala
     */
    private ESala $sala;
    /**
     * Data ed orario della proiezione
     * @AttributeType DateTime
     */
    private DateTime $dataproiezione;

    public function __construct(EFilm $film, ESala $sala, DateTime $dataproiezione)
    {
        $this->film = $film;
        $this->sala = $sala;
        $this->dataproiezione = $dataproiezione;
    }

//-------------- SETTER ----------------------
    /**
     * @param EFilm $film film che verrà proiettato
     */
    public function setFilm(EFilm $film){
        $this->film = $film;
    }
    /**
     * @param ESala $sala sala che ospiterà al proeizione
     */
    public function setSala(ESala $sala){
        $this->sala = $sala;
    }
    /**
     * @param DateTime $dataproiezione data ed orario di svolgimento della proiezione
     */
    public function setDataproiezione(DateTime $dataproiezione){
        $this->dataproiezione = $dataproiezione;
    }

//----------------- GETTER --------------------
    /**
     * @return EFilm film che verrà proiettao
     */
    public function getFilm(): EFilm{
        return $this->film;
    }
    /**
     * @return ESala sala nella quale si terrà al proiezione
     */
    public function getSala(): ESala{
        return $this->sala;
    }
    /**
     * @return DateTime data ed orario di svolgimento
     */
    public function getDataproieizone(): DateTime{
        return $this->dataproiezione;
    }

//------------- ALTRI METODI ----------------
    public function jsonSerialize ()
    {
        return
            [
                'film'   => $this->getFilm(),
                'sala' => $this->getSala(),
                'dataproiezione'   => $this->getDataproieizone(),
            ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "Film: " . $this->getFilm() . "data ed ora: " . $this->getDataproieizone() . " nella sala: " . $this->getSala();
    }

}