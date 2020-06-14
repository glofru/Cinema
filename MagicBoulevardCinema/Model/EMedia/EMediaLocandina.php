<?php


/**
 * Nella classe MediaLocandina sono presenti tutti i metodi e gli attributi necessari alla creazione e gestione di una locandina di un film.
 * Class EMediaLocandina
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EMediaLocandina extends EMedia
{
    /**
     * Film al quale appartiene la locandina.
     * @var EFilm
     */
    private EFilm $film;

    /**
     * EMediaLocandina constructor.
     * @param string $fileName, nome del file.
     * @param string $mimeType, mimeType dle file.
     * @param DateTime $date, data di caricamento del file.
     * @param $immagine, contenuto del file.
     * @param EFilm $film, film al quale appartiene la locandina.
     */
    public function __construct(string $fileName, string $mimeType, DateTime $date, $immagine, EFilm $film) {
        parent::__construct($fileName, $mimeType, $date, $immagine);

        $this->setFilm($film);
    }

    /**
     * @return EFilm, film al quale appartiene la locandina.
     */
    public function getFilm(): EFilm {
        return $this->film;
    }

    /**
     * @param EFilm $film, film al quale appartiene la locandina.
     */
    public function setFilm(EFilm $film): void {
        $this->film = $film;
    }

    /**
     * @return array|mixed, funzione che serializza il contenuto della classe in formato JSON, necessario per rendere l'applicazione RESTFUL.
     */
    public function jsonSerialize() {
        $temp         = parent::jsonSerialize();
        $temp["film"] = $this->film->getId();

        return $temp;
    }
}