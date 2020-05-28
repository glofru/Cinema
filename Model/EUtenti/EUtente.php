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
class EUtente implements JsonSerializable
{
    /**
     * @var string
     */
    private string $nome;
    /**
     * @var string
     */
    private string $cognome;
    /**
     * @var string
     */
    private string $username;
    /**
     * @var string
     */
    private string $password;
    /**
     * @var string
     */
    private string $email;

    private bool $isBanned;

    private int $id = 0;

    /**
     * EUtente constructor.
     * @param string $id
     * @param string $nome
     * @param string $cognome
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct(string $nome, string $cognome, string $username, string $email, string $password, bool $isBanned)
    {
        $this->setNome($nome);
        $this->setCognome($cognome);
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setIsBanned($isBanned);
    }

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

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setIsBanned($isBanned) {
        $this->isBanned = $isBanned;
    }

    public function isBanned(): bool {
        return $this->isBanned;
    }

    /**
     * @return mixed|void
     */
    public function jsonSerialize()
    {
        return [
            'nome' => $this->getNome(),
            'cognome' => $this->getCognome(),
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
            'email' => $this->getEmail()
        ];
    }
}