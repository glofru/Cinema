<?php


/**
 * Nella classe Admin sono presenti tutti i metodi e gli attributi necessari alla creazione di un Utente non registrato.
 * Class ENonRegistrato
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class ENonRegistrato extends EUtente
{
    /**
     * Lista dei biglietti acquistati dall'utente.
     * @var array
     */
    private array $listaBiglietti;

    /**
     * ENonRegistrato constructor.
     * @param string $email, email dell'utente.
     * @param string $password, password dell'utente.
     * @throws Exception, se almeno uno dei parametri passato al costruttore non rispetta la relativa sintassi.
     */
    public function __construct(string $email, string $password)
    {
        parent::__construct("", "", "", $email, $password, false);

        $this->listaBiglietti = array();
    }

    /**
     * @return array, insieme dei biglietti acquistati dall'utente.
     */
    public function getListaBiglietti(): array {
        return $this->listaBiglietti;
    }

    /**
     * @param EBiglietto $biglietto, biglietto acquistato dall'utente.
     */
    public function addBiglietto(EBiglietto $biglietto): void {
        array_push($this->listaBiglietti, $biglietto);
    }

    /**
     * @return array|mixed, funzione che serializza il contenuto della classe in formato JSON, necessario per rendere l'applicazione RESTFULL.
     */
    public function jsonSerialize() {
        $temp = parent::jsonSerialize();

        $temp["biglietti"] = $this->getListaBiglietti();

        return $temp;
    }

}