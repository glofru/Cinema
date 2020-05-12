<?php
/** Nella clesse Utente sono presenti tutti i metodi e attributi necessari a definire il profilo di un
 * generico utente indipendentemente dal ruolo all' interno del sito
 * I suoi attributi sono i seguenti:
 * -nome
 * -cognome
 * -username
 * -password
 * -email
 * -isAdmin: booleano che indica se l'utente in questione si tratta di un administrator
 *           oppure un semplice utente registrato
 *
 * Class Utente
 */
class EUtente
{
    private string $nome;
    private string $cognome;
    private string $username;
    private string $password;
    private string $email;
    private bool $isAdmin;

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * @param string $cognome
     */
    public function setCognome($cognome)
    {
        $this->cognome = $cognome;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }


}