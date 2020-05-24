<?php


/**
 * Class EMediaUtente
 */
class EMediaUtente extends EMedia
{
    /**
     * @var EUtente
     */
    private EUtente $utente;

    /**
     * EMediaUtente constructor.
     * @param string $id
     * @param string $fileName
     * @param string $mimeType
     * @param DateTime $date
     * @param $immagine
     * @param EUtente $utente
     */
    public function __construct(string $fileName, string $mimeType, DateTime $date, $immagine, EUtente $utente)
    {
        parent::__construct($fileName, $mimeType, $date, $immagine);
        $this->setUtente($utente);
    }

    /**
     * @return EUtente
     */
    public function getUtente(): EUtente
    {
        return $this->utente;
    }

    /**
     * @param EUtente $utente
     */
    public function setUtente(EUtente $utente): void
    {
        $this->utente = $utente;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        $temp = parent::jsonSerialize();
        $temp["utente"] = $this->utente->getId();
        return $temp;
    }
}