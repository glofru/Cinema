<?php

/**Nella clesse Utente sono presenti tutti i metodi e attributi necessari a definire il profilo di un utente
 * registrato
 * Class ERegistrato
 */
class ERegistrato extends EUtente
{
    /**
     * @var array
     */
    private array $listagiudizi;

    /**
     * ERegistrato constructor.
     * @param string $nome
     * @param string $cognome
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct(string $nome, string $cognome, string $username, string $email, string $password)
    {
        parent::__construct($nome, $cognome, $username, $email, $password);

        $this->listagiudizi = array();
    }


    /**
     * @return array
     */
    public function getListagiudizi(): array
    {
        return $this->listagiudizi;
    }

    /**
     * @param array $listagiudizi
     */
    public function addGiudizio(EGiudizio $giudizio): void
    {
        array_push($this->listagiudizi, $giudizio);
    }

    //TODO: override jsonsSerialization per aggiungere lista giudizi

}