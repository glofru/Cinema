<?php

/**
 * Nella classe InputChecker sono presenti tutti i metodi e gli attributi necessari alla gestione della correttezza dei valori passati alle entity.
 * Class EInputChecker
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EInputChecker{
    /**
     * Istanza della calsse, gestita come singleton.
     * @var
     */
    private static $instance;

    /**
     * EInputChecker constructor.
     */
    private function __construct() {}

    /**
     * @return EInputChecker
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new EInputChecker();
        }
        return self::$instance;
    }

    /**
     * Funzione che controlla se un nome (o cognome) sia valido.
     * @param string $nome, nome da controllare.
     * @return bool, esiot del controllo.
     */
    public function isNome(string $nome): bool {
        $res = preg_replace("/^[a-zA-Z\ '-]$/", "", $nome);
        return $res == $nome;
    }

    /**
     * Funzione che controlla se un username sia valido.
     * @param string $username, username da controllare.
     * @return bool, esito del controllo.
     */
    public function isUsername(string $username): bool {
        $res = preg_replace("/[^a-zA-Z0-9]/", "", $username);
        return $res == $username && strlen($username) > 1;
    }

    /**
     * Funzione che controlla se un file caricato abbia un mimeType associato ad un file di immagine.
     * @param $typefile, mimeType da controllare.
     * @return bool, esito del controllo.
     */
    public function isImage($typefile): bool
    {
        $estensione = strtolower(strrchr($typefile, '/'));
        switch($estensione)
        {
            case '/jpg':
            case '/jpeg':
            case '/gif':
            case '/png':
                return true;
            default:
                return false;
        }
    }

    /**
     * Funzione che controlla se un file caricato non sia più grande di 2 MB.
     * @param $size, dimensione espressa un byte.
     * @return bool, esito del controllo.
     */
    public function isLight($size) {
        return (intval($size) <  2048000);
    }

    /**
     * Funzione che controlla se una password sia valida.
     * @param string $password, password da controllare.
     * @return bool, esito del controllo.
     */
    public function isPassword(string $password): bool {
        return strlen($password) > 6;
    }

    /**
     * Funzione che controlla se una email sia valida.
     * @param string $email, email da controllare.
     * @return bool, esito del controllo.
     */
    public function isEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Funzione che controlla se una data sia valida.
     * @param string $date, data da controllare.
     * @return string, ritorna la data stessa se corretta o una stringa vuota in caso non sia valida.
     */
    public function date(string $date): string {
        $temp = DateTime::createfromFormat('Y-m-d', $date);
        if($date === false) {
            return "";
        }
        return $date;
    }

    /**
     * Funzione che controlla se una ora sia valida.
     * @param string $hour, ora da controllare.
     * @return string, ritorna l'ora passata se corretta altrimenti viene tornata una stringa vuota.
     */
    public function hour(string $hour): string {
        $res = strtotime($hour);
        if($res !== false){
            return "";
        }
        return $res;
    }

    /**
     * Funzione che controlla se un commento rispetti la dimensione massima e viene effettuato un filtro contro attacchi di tipo XSS.
     * @param string $commento, commento da controllare.
     * @return string, ritorna il commento che eventualemnte viene troncato se supera la dimensione consentita.
     */
    public function comment(string $commento): string {
        if (strlen($commento) === 0) {
            return "Nessun commento.";
        }

        $commento = filter_var($commento, FILTER_SANITIZE_STRING);
        if(strlen($commento) > 200) {
            $commento = substr($commento,0,200);
        }

        return $commento;
    }

    /**
     * Funzione che controlla se un titolo rispetti la dimensione massima e viene effettuato un filtro contro attacchi di tipo XSS.
     * @param string $titolo, titolo da controllare.
     * @return string, ritorna il titolo che eventualemnte viene troncato se supera la dimensione consentita.
     */
    public function title(string $titolo): string {
        if (strlen($titolo) === 0) {
            return "Nessun titolo.";
        }

        $titolo = filter_var($titolo, FILTER_SANITIZE_STRING);
        if(strlen($titolo) > 30) {
            $titolo = substr($titolo,0,30);
        }

        return $titolo;
    }
}
?>