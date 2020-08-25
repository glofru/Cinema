<?php

/**
 * Nella classe SessionManager sono presenti tutti i metodi neccessari a gestire le sessioni per il nostro progetto.
 * Class CSessionManager
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Controller
 */

class CSessionManager
{
    /**
     * Istanza della classe.
     * @var CSessionManager
     */
    private static $instance;

    /**
     * CSessionManager constructor.
     */
    private function __construct() {}

    /**
     * @return CSessionManager
     */
    public static function getInstance(): CSessionManager{
        if (self::$instance == null) {
            self::$instance = new CSessionManager();
        }
        return self::$instance;
    }

    /**
     * Funzione che inizializza lo status della sessione.
     */
    private function beginTheSession(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Funzione che salva i biglietti in sessione.
     * @param $biglietti
     */
    public function saveBiglietti($biglietti) {
        $this->beginTheSession();
        $_SESSION["biglietti"] = serialize($biglietti);
    }

    /**
     * Funzione che carica dalla sessione i biglietti acquistati.
     * @return array
     */
    public function loadBiglietti(): array {
        $this->beginTheSession();
        $biglietti = unserialize($_SESSION["biglietti"]);
        unset($_SESSION["biglietti"]);
        return $biglietti;
    }

    /**
     * Funzione che salva in sessione l'id di un particolare film con il quale si sta interagendo.
     * @param $id
     */
    public function saveFilmId($id) {
        $this->beginTheSession();
        $_SESSION["idFilm"] = $id;
    }

    /**
     * Funzione che restituisce l'id del film salvato in sessione.
     * @return int
     */
    public function loadFilmId(): int {
        $this->beginTheSession();
        $id = $_SESSION["idFilm"];
        unset($_SESSION["idFilm"]);
        return $id;
    }

    /**
     * Funzione che distrugge la sessione ed il relativo Cookie PHPSESSID
     * @return bool
     */
    public function destorySession(): bool {
        if (isset($_COOKIE["PHPSESSID"])) {
            $this->beginTheSession();
            session_unset();
            session_destroy();
            setcookie("PHPSESSID", "", time() - 3600, "/");
            $bool = true;
        }
        return $bool;
    }

    /**
     * Funzione che ci permette di salvare l'utente in sessione.
     * @param $utente
     */
    public function saveUtente($utente) {
        $this->beginTheSession();
        session_regenerate_id(true);
        session_set_cookie_params(time() + 3600, "/", null, false, true); //http only cookie, add session.cookie_httponly=On on php.ini | Andrebbe inoltre inserito il 4° parametro
        // a TRUE per fare si che il cookie viaggi solo su HTTPS. E' FALSE perchè non abbiamo un certificato SSL ma in un contesto reale va messo a TRUE!!!
        $salvare = serialize($utente);

        if ($utente->isVisitatore()) {
            $_SESSION['visitatore'] = $salvare;
        } else {
            if(isset($_SESSION["visitatore"])){
                unset($_SESSION["visitatore"]);
            }

            if ($utente->isRegistrato() || $utente->isAdmin()) {
                $_SESSION['utente']        = $salvare;
            } else {
                $_SESSION['nonRegistrato'] = $salvare;
            }
        }
    }

    /**
     * Funzione che ci permette di verificare se l'utente è loggato nel sistema.
     * @return bool
     */
    public function isLogged(): bool {
        $this->beginTheSession();
        return isset($_COOKIE["PHPSESSID"]) && isset($_SESSION["utente"]);
    }

    /**
     * Funzione che restituisce l'utente se quest'ultimo è un Registrato o NonRegistrato. Restituisce NULL altrimenti.
     * @return mixed|null
     */
    public function getUtente() {
        $this->beginTheSession();
        if(isset($_SESSION["utente"])){
           $utente =  $_SESSION["utente"];
        } else {
            $utente =  $_SESSION["nonRegistrato"];
        }
        return isset($utente) ? unserialize($utente) : NULL;
    }

    /**
     * Funzione che recupera l'utente Visitatore dalla sessione.
     * @return EVisitatore
     */
    public function getVisitatore(): EVisitatore {
        $this->beginTheSession();
        return unserialize($_SESSION["visitatore"]);
    }

}