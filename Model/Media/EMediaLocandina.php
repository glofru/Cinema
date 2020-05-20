<?php


/**
 * Class EMediaLocandina
 */
class EMediaLocandina extends EMedia
{
    /**
     * @var EFilm
     */
    private EFilm $film;

    /**
     * EMediaLocandina constructor.
     * @param string $id
     * @param string $fileName
     * @param string $mimeType
     * @param DateTime $date
     * @param EFilm $film
     */
    public function __construct(string $id, string $fileName, string $mimeType, DateTime $date, EFilm $film)
    {
        parent::__construct($id, $fileName, $mimeType, $date);
        $this->setFilm($film);
    }

    /**
     * @return EFilm
     */
    public function getFilm(): EFilm
    {
        return $this->film;
    }

    /**
     * @param EFilm $film
     */
    public function setFilm(EFilm $film): void
    {
        $this->film = $film;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        $temp = parent::jsonSerialize();
        $temp["film"] = $this->film->getId();
        return $temp;
    }
}