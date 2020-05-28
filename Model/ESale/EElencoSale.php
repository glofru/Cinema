<?php


/**
 * Class EElencoSale
 */
class EElencoSale
{
    /**
     * @var array
     */
    private array $sale;

    /**
     * ElencoSale constructor.
     */
    public function __construct()
    {
        $sale = array();
    }

    /**
     * @param ESalaFisica $sala
     */
    public function addSala(ESalaFisica $sala)
    {
        $this->sale[$sala->getNumeroSala()] = $sala;
    }

    /**
     * @param int $numero
     * @return ESalaVirtuale|null
     */
    public function getSala(int $numero)
    {
        if (array_key_exists($numero, $this->sale))
        {
            return ESalaVirtuale::fromSalaFisica($this->sale[$numero]);
        }

        return null;
    }
}