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

    private array $preferences;

    /**
     * EUtente constructor.
     * @param string $nome
     * @param string $cognome
     * @param string $username
     * @param string $email
     * @param string $password
     * @param bool $isBanned
     * @throws Exception
     */
    public function __construct(string $nome, string $cognome, string $username, string $email, string $password, bool $isBanned)
    {
        if ($this instanceof ENonRegistrato) {
            $this->nome = "";
            $this->cognome = "";
            $this->username = "";
            $this->setEmail($email);
            $this->password = $password;
            $this->isBanned = false;

        } else if ($this instanceof EVisitatore) {
            $this->nome = "";
            $this->cognome = "";
            $this->username = "";
            $this->email = "";
            $this->password = "";
            $this->isBanned = false;
        } else {
            $this->setNome($nome);
            $this->setCognome($cognome);
            $this->setUsername($username);
            $this->setEmail($email);
            $this->setPassword($password);
            $this->setIsBanned($isBanned);
        }
        $this->preferences = array();
        $this->preferences();
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
     * @throws Exception
     */
    public function setNome($nome)
    {
        if (EInputChecker::getInstance()->isNome($nome)) {
            str_replace("\'", "'", $nome);
            $this->nome = $nome;
        } else {
            throw new Exception("Nome non valido");
        }
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
     * @throws Exception
     */
    public function setCognome($cognome)
    {
        if (EInputChecker::getInstance()->isNome($cognome)) {
            $this->cognome = $cognome;
        } else {
            throw new Exception("Cognome non valido");
        }
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
     * @throws Exception
     */
    public function setUsername($username)
    {
        if (EInputChecker::getInstance()->isUsername($username)) {
            $this->username = $username;
        } else {
            throw new Exception("Username non valido");
        }
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
     * @throws Exception
     */
    public function setPassword($password)
    {
        if (EInputChecker::getInstance()->isPassword($password)) {
            $this->password = $password;
        } else {
            throw new Exception("Password non valida");
        }
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
     * @throws Exception
     */
    public function setEmail($email)
    {
        if (EInputChecker::getInstance()->isEmail($email)) {
            $this->email = $email;
        } else {
            throw new Exception("Email non valida");
        }
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

    private function getPreferencesArray(){
        return $this->preferences;
    }

    public function setPreferece(string $genere, int $value) {
        $this->preferences[$genere] = $value;
    }

    public function isAdmin(): bool {
        return $this instanceof EAdmin;
    }

    public function isRegistrato(): bool {
        return $this instanceof ERegistrato;
    }

    public function isVisitatore(): bool {
        return $this instanceof EVisitatore;
    }

    private function preferences () {
        if(!isset($_COOKIE['preferences'])) {
            $generi = EGenere::getAll();
            foreach ($generi as $key) {
                $this->setPreferece($key, 0);
            }
            $value = serialize($this->preferences);
            setcookie('preferences', $value, time() + (86400 * 30), "/");
        } else {
            $this->preferences = unserialize($_COOKIE['preferences']);
        }
        return $this->getPreferencesArray();
    }

    public function getPreferences() {
        $this->preferences();
        $isEmpty = true;
        $temp_values = [];
        $all = 0;
        foreach($this->getPreferencesArray() as $key => $a) {
            if($a !== 0) {
                $isEmpty = false;
                $all += $a;
                $temp_values[$key] = $a;
            }
        }
        if($isEmpty === true) {return true;}
        foreach($temp_values as $key => $arr) {
            $temp_values[$key] = round(round(($arr / $all) * 100) * (10/100));
        }
        return $temp_values;
    }

    public function incrementPreference(string $genere) {
        $this->preferences();
        $this->preferences[$genere]++;
        setcookie('preferences', serialize($this->getPreferencesArray()), time() + (86400 * 30), "/");
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