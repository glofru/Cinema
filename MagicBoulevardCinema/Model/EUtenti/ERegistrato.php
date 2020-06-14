<?php

/**Nella clesse registrato sono presenti tutti i metodi e attributi necessari a definire il profilo di un Utente registrato.
 * Class ERegistrato
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class ERegistrato extends EUtente
{
    /**
     * Lista dei giudizi espressi dall'utente.
     * @var array
     */
    private array $listaGiudizi;

    /**
     * Lista dei biglietti acquistati dall'utente.
     * @var array
     */
    private array $listaBiglietti;

    /**
     * ERegistrato constructor.
     * @param string $nome, nome dell'utente.
     * @param string $cognome, cognome dell'utente.
     * @param string $username, username dell'utente
     * @param string $email, email dell'utente.
     * @param string $password, password dell'utente.
     * @throws Exception, se almeno uno dei parametri passato al costruttore non rispetta la relativa sintassi.
     */
    public function __construct(string $nome, string $cognome, string $username, string $email, string $password, bool $isBanned) {
        parent::__construct($nome, $cognome, $username, $email, $password, $isBanned);

        $this->listaGiudizi   = array();
        $this->listaBiglietti = array();
    }


    /**
     * @return array, insieme dei giudizi espressi dall'utente
     */
    public function getListaGiudizi(): array {
        return $this->listaGiudizi;
    }

    /**
     * @param EGiudizio $giudizio, giudizio da aggiungere alla lsita.
     */
    public function addGiudizio(EGiudizio $giudizio): void {
        array_push($this->listaGiudizi, $giudizio);
    }

    /**
     * @param EGiudizio $giudizio, giudizio da rimuovere dall'insieme.
     */
    public function removeGiudizio(EGiudizio $giudizio) {
        $value = false;

        foreach ($this->listaGiudizi as $key => $item) {
            if($item->getfilm()->getId() === $item->getFilm()->getId()) {
                $value = $key;
                break;
            }
        }

        if($value !== false) {
            unset($this->listaGiudizi[$value]);
            $this->listaGiudizi = array_values($this->listaGiudizi);
        }
    }

    /**
     * @return array, lista dei biglietti acquistati.
     */
    public function getListaBiglietti(): array {
        return $this->listaBiglietti;
    }

    /**
     * @param EBiglietto $biglietto, biglietto da aggiungere.
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
        $temp["giudizi"]   = $this->getListaGiudizi();

        return $temp;
    }

}