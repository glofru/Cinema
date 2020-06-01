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
    private bool $isUsed;
    /**
     * @var EUtente
     */
    private EUtente $utente;

    /**
     * EToken constructor.
     * @param string $value
     * @param bool $isUsed
     * @param EUtente $utente
     */
    public function __construct(string $value, bool $isUsed, EUtente $utente)
    {
        $this->setValue($value);
        $this->setIsUsed($isUsed);
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
     * @return bool
     */
    public function isUsed(): bool
    {
        return $this->isUsed;
    }

    /**
     * @param bool $isUsed
     */
    public function setIsUsed(bool $isUsed): void
    {
        $this->isUsed = $isUsed;
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
        return "Value: " . $this->getValue() . ", isUsed: " . $this->isUsed()?"true":"false";
    }
}