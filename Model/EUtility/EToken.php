<?php


class EToken
{
    private string $value;
    private bool $isUsed;

    /**
     * EToken constructor.
     * @param string $value
     * @param bool $isUsed
     */
    public function __construct(string $value, bool $isUsed)
    {
        $this->value = $value;
        $this->isUsed = $isUsed;
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
}