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
     * @throws Exception
     */
    public function __construct(string $nome, string $cognome, string $username, string $email, string $password, bool $isBanned)
    {
        parent::__construct($nome, $cognome, $username, $email, $password, $isBanned);
    }

    public function addFilm() {
        echo "Aggiunta film";
    }
}