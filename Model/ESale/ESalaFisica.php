<?php


/**
 * Class ESalaFisica
 */
class ESalaFisica implements JsonSerializable
{
    /**
     * @var int
     */
    private int $numeroSala;
    /**
     * @var int
     */
    private int $nFile;
    /**
     * @var int
     */
    private int $nPostiFila;
    /**
     * @var bool
     */
    private bool $disponibile;

    /**
     * ESalaFisica constructor.
     * @param int $numeroSala
     * @param int $nFile
     * @param int $nPostiFila
     * @param bool $disponibile
     */
    public function __construct(int $numeroSala, int $nFile, int $nPostiFila, bool $disponibile)
    {
        $this->setNumeroSala($numeroSala);
        $this->setNFile($nFile);
        $this->setNPostiFila($nPostiFila);
        $this->setDisponibile($disponibile);
    }

    /**
     * @return int
     */
    public function getNumeroSala(): int
    {
        return $this->numeroSala;
    }

    /**
     * @param int $numeroSala
     */
    public function setNumeroSala(int $numeroSala): void
    {
        $this->numeroSala = $numeroSala;
    }

    /**
     * @return int
     */
    public function getNFile(): int
    {
        return $this->nFile;
    }

    /**
     * @param int $nFile
     */
    public function setNFile(int $nFile): void
    {
        $this->nFile = $nFile;
    }

    /**
     * @return int
     */
    public function getNPostiFila(): int
    {
        return $this->nPostiFila;
    }

    /**
     * @param int $nPostiFila
     */
    public function setNPostiFila(int $nPostiFila): void
    {
        $this->nPostiFila = $nPostiFila;
    }

    /**
     * @return bool
     */
    public function isDisponibile(): bool
    {
        return $this->disponibile;
    }

    /**
     * @param bool $disponibile
     */
    public function setDisponibile(bool $disponibile): void
    {
        $this->disponibile = $disponibile;
    }

    /**
     * @return mixed|void
     */
    public function jsonSerialize()
    {
        return [
            'numeroSala' => $this->getNumeroSala(),
            'nFile' => $this->getNFile(),
            'nPostiFila' => $this->getNPostiFila(),
            'disponibile' => $this->isDisponibile()
        ];
    }
}