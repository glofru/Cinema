<?php

/**
 * Classe che permette il salvataggio e il caricamento di oggetti Eutente (EUtenteRegistrato o EAdmin) dal DB.
 * Class FUtente
 * @author Lofrumento - Di Santo - Susanna
 * @package Foundation
 */
class FUtente implements Foundation
{

    /**
     * Nome della classe.
     * @var string
     */
    private static string $className  = "FUtente";

    /**
     * Nome della corrispondente tabella presente sul DB.
     * @var string
     */
    private static string $tableName  = "Utenti";

    /**
     * Insieme delle colonne presenti nella tabella sul DB che verrà sostituita in fase di binding.
     * @var string
     */
    private static string $valuesName = "(:id,:username,:email,:nome,:cognome,:password,:isAdmin,:isBanned)";

    /**
     * FUtente constructor.
     */
    public function __construct() {}

    /**
     * Funzione che esegue il binding fra i parametri ed i reali valori da assegnare per salvare l'oggetto.
     * @param PDOStatement $sender
     * @param $utente, oggetto dal quale si vogliono prelevare i valori.
     * @return mixed|void
     */
    public static function associate(PDOStatement $sender, $utente){
        if ($utente instanceof EUtente) {
            $sender->bindValue(':id',       NULL,                                          PDO::PARAM_INT);
            $sender->bindValue(':username', $utente->getUsername(),                        PDO::PARAM_STR);
            $sender->bindValue(':email',    $utente->getEmail(),                           PDO::PARAM_STR);
            $sender->bindValue(':nome',     str_replace("'", "\'", $utente->getNome()),    PDO::PARAM_STR);
            $sender->bindValue(':cognome',  str_replace("'", "\'", $utente->getCognome()), PDO::PARAM_STR);
            $sender->bindValue(':password', $utente->getPassword(),                        PDO::PARAM_STR);
            $sender->bindValue(':isAdmin',  $utente instanceof EAdmin,                     PDO::PARAM_BOOL);
            $sender->bindValue(':isBanned', $utente->isBanned(),                           PDO::PARAM_BOOL);
        } else {
            die("Not a user!!");
        }
    }

    /**
     * Funzione che ritorna il nome della classe.
     * @return string
     */
    public static function getClassName(): string {
        return self::$className;
    }

    /**
     * Funzione che ritorna il nome della tabella presente sul DB.
     * @return string
     */
    public static function getTableName(): string {
        return self::$tableName;
    }

    /**
     * Funzione che ritorna i valori delle colonne della tabella per il binding.
     * @return string
     */
    public static function getValuesName(): string {
        return self::$valuesName;
    }

    /**
     * Funzione che permette di salvare un Utente sul DB.
     * @param EUtente $utente, utente da salvare.
     * @throws Exception
     */
    public static function save(EUtente $utente) {
        $db = FDatabase::getInstance();

        $utente->setPassword(self::hash($utente->getPassword()));

        $id = $db->saveToDB(self::getClassName(), $utente);
        $utente->setId($id);
    }

    /**
     * Funzione che permette di caricare un utente dal DB. Si appoggia alla funzione parseResult per ottenere come risultato un array di oggetti.
     * @param string $value, valore da usare per identificare l'oggetto.
     * @param string $row, colonna nella quale cercare il valore.
     * @return EUtente, oggetto EUtente.
     */
    public static function load(string  $value, string $row) {
        $db     = FDatabase::getInstance();

        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        return self::parseResult($result)[0];
    }


    /**
     * Funzione che carica dal DB tutti gli utenti attualmente bannati. Si appoggia alla funzione parseResult per ottenere come risultato un array di oggetti.
     * @return array|null[], insieme di utenti bannati.
     */
    public static function loadBannati() {
        $db     = FDatabase::getInstance();

        $result = $db->loadFromDB(self::getClassName(), '1', 'isBanned');
        if ($result == null) {
            return [];
        }

        return self::parseResult($result);
    }

    /**
     * Funzione che permette attraverso i dati di login di reperire l'utente nel database. Può tornare un utente nel caso il login vada a buon fine oppure null altrimenti. Si appoggia alla funzione parseResult per ottenere come risultato un array di oggetti.
     * @param string $value, username o email dell'utente.
     * @param string $pass, password dell'utente.
     * @param bool $isMail, se il valore passato è un username o uan mail.
     * @return EUtente|null
     */
    public static function login(string $value, string $pass, bool $isMail) {
        $db = FDatabase::getInstance();

        if($isMail) {
            $result  = $db->loadFromDB(self::getClassName(), $value, "email");
        } else {
            $result  = $db->loadFromDB(self::getClassName(), $value, "username");
        }

        $utente      = self::parseResult($result)[0];

        if ($utente != null) {
            if (password_verify($pass, $utente->getPassword())) {
                return $utente;
            }
        }

        return null;
    }

    /**
     * Funzione che permette di aggiornare un oggetto Utente nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indetificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @param $newvalue, valore che si vuole inserire.
     * @param $newrow, colonna nella quale inserire il nuovo valore.
     * @return bool, risultato dell'operazione.
     */
    public static function update($value, $row, $newvalue, $newrow): bool {
        $db = FDatabase::getInstance();

        return $db->updateTheDB(self::getClassName(), $value, $row, $newvalue, $newrow);
    }

    /**
     * Funzione che elimina un oggetto nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indetificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @return bool, risultato dell'operazione.
     */
    public static function delete($value, $row): bool {
        $db = FDatabase::getInstance();

        return $db->deleteFromDB(self::getClassName(), $value, $row);
    }

    /**
     * funzione che aggiorna la password di un utente. Ritorna l'esito dell'operazione.
     * @param EUtente $utente, utente al quale si vuoel cambiare password.
     * @return bool, esito dell'operazione.
     * @throws Exception
     */
    public static function updatePwd(EUtente $utente): bool {
        $utente->setPassword(self::hash($utente->getPassword()));

        return self::update($utente->getId(), "id", $utente->getPassword(), "password");
    }

    /**
     * Funzione che, dato un array di righe ritornate dal DB, permette di ricostruire oggetti della classe EUtente ed inserirli un array da ritornare.
     * @param array $result, righe del database che si vuole 'parsare'.
     * @return array|null[], array di EUtente o [null].
     */
    private static function parseResult(array $result): array {
        $return = [];

        foreach ($result as $row) {
            $id         = $row["id"];
            $nome       = $row["nome"];
            $cognome    = $row["cognome"];
            $username   = $row["username"];
            $email      = $row["email"];
            $password   = $row["password"];
            $isAdmin    = $row["isAdmin"];
            $isBanned   = $row["isBanned"];

            try {
                if ($isAdmin) {
                    $utente = new EAdmin($nome, $cognome, $username, $email, $password, $isBanned);
                } elseif ($username != null && $username != "") {
                    $utente = new ERegistrato($nome, $cognome, $username, $email, $password, $isBanned);
                } else {
                    $utente = new ENonRegistrato($email, $password);
                }
            } catch (Exception $e) {
                if ($e->getMessage() === "Password non valida") {
                    return [null];
                }
            }

            $utente->setId($id);
            array_push($return, $utente);
        }

        return $return;
    }

    /**
     * Funzione che controlla se l'utente inserito esiste nel DB. Il parametro checkMail specifica se controllare l'utente per email oppure per username.
     * @param EUtente $utente, utente che si vuole controllare se esista sul DB.
     * @param bool|null $checkMail, identifica se effettuare il controllo attraverso la mail o l'username dell'utente.
     * @return bool, esito dell'operazione.
     */
    public static function exists(EUtente $utente, bool $checkMail = null): bool {
        $db         = FDatabase::getInstance();

        $resultMail = $db->loadFromDB(self::getClassName(), $utente->getEmail(), "email");
        $existsMail = $resultMail != null && sizeof($resultMail) > 0;

        if ($checkMail) {
            return $existsMail;
        }

        $resultUser = $db->loadFromDB(self::getClassName(), $utente->getUsername(), "username");
        $existsUser = $resultUser != null && sizeof($resultUser) > 0;

        if (!$checkMail) {
            return $existsUser;
        }

        return $existsMail && $existsUser;
    }

    /**
     * Funzione di ausilio che cifra la password via Bcrypt prima di salvarla sul DB.
     * @param string $password, password da cifrare.
     * @return false|string|null esito della cifratura. Ritorna una stringa se tutto è andato a buon fine.
     */
    private static function hash(string $password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
