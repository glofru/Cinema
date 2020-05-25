<?php


/**
 * Class EPersona
 */
class EPersona implements JsonSerializable
{
    /**
     * @var int
     */
    private int $id = 0;
    /**
     * @var string
     */
    private string $nome;
    /**
     * @var string
     */
    private string $cognome;
    /**
     * @var string
     */
    private string $imdbUrl;
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
     * @param string $imdbUrl
     * @param bool $isAttore
     * @param bool $isRegista
     */
    public function __construct(string $nome, string $cognome, string $imdbUrl, bool $isAttore, bool $isRegista)
    {
        $this->setNome($nome);
        $this->setCognome($cognome);
        $this->setImdbUrl($imdbUrl);
        $this->setIsAttore($isAttore);
        $this->setIsRegista($isRegista);
    }

    /**
     * @return string
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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

    public function getFullName(): string
    {
        return $this->getNome() . " " . $this->getCognome();
    }

    /**
     * @return string
     */
    public function getImdbUrl(): string
    {
        return $this->imdbUrl;
    }

    /**
     * @param string $imdbUrl
     */
    public function setImdbUrl(string $imdbUrl): void
    {
        $this->imdbUrl = $imdbUrl;
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
            'imdbUrl' => $this->getImdbUrl(),
            'isAttore' => $this->isAttore(),
            'isRegista' => $this->isRegista()
        ];
    }
}