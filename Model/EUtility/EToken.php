<?php


/**
 * Class EToken
 */
class EToken
{
    /**
     * @var string
     */
    private string $value;
    /**
     * @var bool
     */
    private DateTime $creationDate;
    /**
     * @var EUtente
     */
    private EUtente $utente;

    /**
     * EToken constructor.
     * @param string $value
     * @param DateTime $creationDate
     * @param EUtente $utente
     */
    public function __construct(string $value, DateTime $creationDate, EUtente $utente)
    {
        $this->setValue($value);
        $this->setCreationDate($creationDate);
        $this->setUtente($utente);
    }


    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return DateTime
     */
    public function getCreationDate(): DateTime
    {
        return $this->creationDate;
    }

    public function getCreationdateDB(): string {
        return $this->getCreationDate()->format('Y-m-d');
    }

    public function getCreationHour(): string {
        return $this->getCreationDate()->format('H:i:s');
    }

    /**
     * @param DateTime $creationDate
     */
    public function setCreationDate(DateTime $creationDate): void
    {
        $this->creationDate = $creationDate;
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
     * @return string
     */
    public function __toString(): string
    {
        return "Value: " . $this->getValue() . ", isUsed: " . $this->amIValid()?"true":"false";
    }

    public function amIValid(): bool {
        $maybeExpired = new DateTime('now -1 Hour');
        return $this->getCreationDate() >= $maybeExpired;
    }
}