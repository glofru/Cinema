<?php


/**
 * Class ENonRegistrato
 */
class ENonRegistrato extends EUtente
{
    private array $listaBiglietti;
    /**
     * ENonRegistrato constructor.
     * @param string $email
     * @param string $password
     * @throws Exception
     */
    public function __construct(string $email, string $password)
    {
        parent::__construct("", "", "", $email, $password, false);
        $this->listaBiglietti = array();
    }

    public function getListaBiglietti(): array
    {
        return $this->listaBiglietti;
    }

    /**
     * @param array $listagiudizi
     */
    public function addBiglietto(EBiglietto $biglietto): void
    {
        array_push($this->listaBiglietti, $biglietto);
    }

}