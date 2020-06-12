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
     * @AttributeType ESalaVirtuale
     */
    private ESalaVirtuale $sala;
    /**
     * Data ed orario della proiezione
     * @AttributeType DateTime
     */
    private DateTime $dataproiezione;

    private int $id = 0;
    public function __construct(EFilm $film, ESalaVirtuale $sala, DateTime $dataproiezione)
    {
        $this->setFilm($film);
        $this->setSala($sala);
        $this->setDataproiezione($dataproiezione);
    }

//-------------- SETTER ----------------------
    /**
     * @param EFilm $film film che verrà proiettato
     */
    public function setFilm(EFilm $film){
        $this->film = $film;
    }
    /**
     * @param ESalaVirtuale $sala sala che ospiterà al proeizione
     */
    public function setSala(ESalaVirtuale $sala){
        $this->sala = $sala;
    }
    /**
     * @param DateTime $dataproiezione data ed orario di svolgimento della proiezione
     */
    public function setDataproiezione(DateTime $dataproiezione){
        $this->dataproiezione = clone $dataproiezione;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function getId(): int{
        return $this->id;
    }

//----------------- GETTER --------------------
    /**
     * @return EFilm film che verrà proiettao
     */
    public function getFilm(): EFilm{
        return $this->film;
    }
    /**
     * @return ESalaVirtuale sala nella quale si terrà al proiezione
     */
    public function getSala(): ESalaVirtuale{
        return $this->sala;
    }
    /**
     * @return DateTime data ed orario di svolgimento
     */
    public function getDataproieizone(): DateTime{
        return $this->dataproiezione;
    }

    public function getData(): string {
        return $this->dataproiezione->format('d-m-Y');
    }

    public function getDataRed(): string {
        return $this->dataproiezione->format('d-m H:i');
    }

    public function getDataSQL(): string {
        return $this->dataproiezione->format('Y-m-d');
    }

    public function getOra(): string {
        return $this->dataproiezione->format('H:i');
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
        return "Film: " . $this->getFilm()->getNome() . "data ed ora: " . $this->getDataproieizone()->format("Y-m-d H:i") . " nella sala: " . $this->getSala()->getNumeroSala();
    }

}