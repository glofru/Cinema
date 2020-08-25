<?php


class CSessionManager
{
    /**
     * Istanza della classe.
     * @var CSessionManager
     */
    private static $instance;

    private function __construct() {}

    public static function getInstance(): CSessionManager{
        if (self::$instance == null) {
            self::$instance = new CSessionManager();
        }
        return self::$instance;
    }

    private function beginTheSession(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function saveBiglietti($biglietti) {
        $this->beginTheSession();
        $_SESSION["biglietti"] = serialize($biglietti);
    }

    public function loadBiglietti(): array {
        $this->beginTheSession();
        $biglietti = unserialize($_SESSION["biglietti"]);
        unset($_SESSION["biglietti"]);
        return $biglietti;
    }

    public function saveFilmId($id) {
        $this->beginTheSession();
        $_SESSION["idFilm"] = $id;
    }

    public function loadFilmId(): int {
        $this->beginTheSession();
        $id = $_SESSION["idFilm"];
        unset($_SESSION);
        return $id;
    }

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

    public function isLogged(): bool {
        $this->beginTheSession();
        return isset($_COOKIE["PHPSESSID"]) && isset($_SESSION["utente"]);
    }

    public function getUtente() {
        $this->beginTheSession();
        if(isset($_SESSION["utente"])){
           $utente =  $_SESSION["utente"];
        } else {
            $utente =  $_SESSION["nonRegistrato"];
        }
        return isset($utente) ? unserialize($utente) : NULL;
    }

    public function getVisitatore(): EVisitatore {
        $this->beginTheSession();
        return unserialize($_SESSION["visitatore"]);
    }

}