<?php


/**
 * Nella classe SalaFisica sono presenti tutti i metodi e gli attributi necessari alla creazione e gestione di una SalaFisica.
 * Class ESalaFisica
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class ESalaFisica implements JsonSerializable
{
    /**
     * Numero della sala.
     * @var int
     */
    private int $numeroSala;
    /**
     * Numero di file presenti nella sala.
     * @var int
     */
    private int $nFile;
    /**
     * Numero di posti presenti in ongi fila.
     * @var int
     */
    private int $nPostiFila;
    /**
     * Identifica se la sala sia disponibile ad ospitare delle proiezione o sia interdetta per motivi logistici.
     * @var bool
     */
    private bool $disponibile;

    /**
     * ESalaFisica constructor.
     * @param int $numeroSala , numero della sala.
     * @param int $nFile , numero di file nella sala.
     * @param int $nPostiFila , nuero di posti per ogni fila presente in sala.
     * @param bool $disponibile , disponibilità della sala.
     * @throws Exception
     */
    public function __construct(int $numeroSala, int $nFile, int $nPostiFila, bool $disponibile)
    {
        $this->setNumeroSala($numeroSala);
        $this->setNFile($nFile);
        $this->setNPostiFila($nPostiFila);
        $this->setDisponibile($disponibile);
    }

    /**
     * @return int, numero della sala.
     */
    public function getNumeroSala(): int
    {
        return $this->numeroSala;
    }

    /**
     * @param int $numeroSala , numero della sala.
     * @throws Exception
     */
    public function setNumeroSala(int $numeroSala): void
    {
        if($numeroSala <= 0) {
            throw (new Exception("Numero sala non valido"));
        }
        $this->numeroSala = $numeroSala;
    }

    /**
     * @return int, numero di file.
     */
    public function getNFile(): int
    {
        return $this->nFile;
    }

    /**
     * @param int $nFile , numero di file.
     * @throws Exception
     */
    public function setNFile(int $nFile): void
    {
        if($nFile <= 0) {
            throw (new Exception("Numero fila non valido"));
        }
        $this->nFile = $nFile;
    }

    /**
     * @return int, numero di posti per fila.
     */
    public function getNPostiFila(): int
    {
        return $this->nPostiFila;
    }

    /**
     * @param int $nPostiFila , numero di posti per fila.
     * @throws Exception
     */
    public function setNPostiFila(int $nPostiFila): void
    {
        if($nPostiFila <= 0) {
            throw (new Exception("Numero posti per fila non valido"));
        }
        $this->nPostiFila = $nPostiFila;
    }

    /**
     * @return bool, disponibilità della sala ad essere utilizzata.
     */
    public function isDisponibile(): bool
    {
        return $this->disponibile;
    }

    /**
     * @param bool $disponibile, disponibilità della sala ad essere utilizzata.
     */
    public function setDisponibile(bool $disponibile): void
    {
        $this->disponibile = $disponibile;
    }

    /**
     * @return mixed|void, funzione che serializza il contenuto della classe in formato JSON, necessario per rendere l'applicazione RESTFULL.
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