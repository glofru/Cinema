<?php


/**
 * Class EAdmin
 */
class EAdmin extends EUtente
{
    /**
     * EAdmin constructor.
     * @param string $id
     * @param string $nome
     * @param string $cognome
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct(string $nome, string $cognome, string $username, string $email, string $password)
    {
        parent::__construct($nome, $cognome, $username, $email, $password);
    }

    public function addFilm() {
        echo "Aggiunta film";
    }
}