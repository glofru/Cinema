<?php


/**
 * Class ENonRegistrato
 */
class ENonRegistrato extends EUtente
{
    /**
     * ENonRegistrato constructor.
     * @param string $id
     * @param string $nome
     * @param string $cognome
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct(string $id, string $nome, string $cognome, string $username, string $email, string $password)
    {
        parent::__construct($id, $nome, $cognome, $username, $email, $password);
    }

    public function compra() {
        echo "Compra non registrato";
    }

}