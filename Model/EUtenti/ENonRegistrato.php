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
    public function __construct(string $nome, string $cognome, string $username, string $email, string $password, bool $isBanned)
    {
        parent::__construct($nome, $cognome, $username, $email, $password, $isBanned);
    }

    public function compra() {
        echo "Compra non registrato";
    }

}