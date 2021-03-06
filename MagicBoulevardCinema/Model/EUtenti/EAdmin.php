<?php


/**
 * Nella classe Admin sono presenti tutti i metodi e gli attributi necessari alla creazione di un Utente admin.
 * Class EAdmin
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EAdmin extends EUtente
{
    /**
     * EAdmin constructor.
     * @param string $nome , nome dell'utente.
     * @param string $cognome , cognome dell'utente.
     * @param string $username , username dell'utente
     * @param string $email , email dell'utente.
     * @param string $password , password dell'utente.
     * @param bool $isBanned
     * @throws Exception , se almeno uno dei parametri passato al costruttore non rispetta la relativa sintassi.
     */
    public function __construct(string $nome, string $cognome, string $username, string $email, string $password, bool $isBanned) {
        parent::__construct($nome, $cognome, $username, $email, $password, $isBanned);
    }

    /**
     * @return array|mixed, funzione che serializza il contenuto della classe in formato JSON, necessario per rendere l'applicazione RESTFULL.
     */
    public function jsonSerialize() {
        return parent::jsonSerialize();
    }
}