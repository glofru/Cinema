<?php


/**
 * Class EPersona
 */
class EPersona implements JsonSerializable
{
    /**
     * @var string
     */
    private string $nome;
    /**
     * @var string
     */
    private string $cognome;
    /**
     * @var DateTime
     */
    private DateTime $nascita;
    /**
     * @var bool
     */
    private bool $isAttore;
    /**
     * @var bool
     */
    private bool $isRegista;

    /**
     * EPersona constructor.
     * @param string $nome
     * @param string $cognome
     * @param DateTime $nascita
     * @param bool $isAttore
     * @param bool $isRegista
     */
    public function __construct(string $nome, string $cognome, DateTime $nascita, bool $isAttore, bool $isRegista)
    {
        $this->setNome($nome);
        $this->setCognome($cognome);
        $this->setNascita($nascita);
        $this->setIsAttore($isAttore);
        $this->setIsRegista($isRegista);
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getCognome(): string
    {
        return $this->cognome;
    }

    /**
     * @param string $cognome
     */
    public function setCognome(string $cognome): void
    {
        $this->cognome = $cognome;
    }

    /**
     * @return DateTime
     */
    public function getNascita(): DateTime
    {
        return $this->nascita;
    }

    /**
     * @param DateTime $nascita
     */
    public function setNascita(DateTime $nascita): void
    {
        $this->nascita = $nascita;
    }

    /**
     * @return bool
     */
    public function isAttore(): bool
    {
        return $this->isAttore;
    }

    /**
     * @param bool $isAttore
     */
    public function setIsAttore(bool $isAttore): void
    {
        $this->isAttore = $isAttore;
    }

    /**
     * @return bool
     */
    public function isRegista(): bool
    {
        return $this->isRegista;
    }

    /**
     * @param bool $isRegista
     */
    public function setIsRegista(bool $isRegista): void
    {
        $this->isRegista = $isRegista;
    }

    /**
     * @return mixed|void
     */
    public function jsonSerialize()
    {
        return [
            'nome' => $this->getNome(),
            'cognome' => $this->getCognome(),
            'nascita' => $this->getNascita()->format("Y-m-d"),
            'isAttore' => $this->isAttore(),
            'isRegista' => $this->isRegista()
        ];
    }
}