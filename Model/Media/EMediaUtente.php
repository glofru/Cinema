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
     * @param EUtente $utente
     */
    public function __construct(string $id, string $fileName, string $mimeType, DateTime $date, EUtente $utente)
    {
        parent::__construct($id, $fileName, $mimeType, $date);
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

    public function jsonSerialize()
    {
        $temp = parent::jsonSerialize();
        $temp["utente"] = $this->utente->getId();
        return $temp;
    }
}