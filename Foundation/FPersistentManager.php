<?php


/**
 * Class FPersistentManager
 */
class FPersistentManager
{
    /**
     * @var FPersistentManager
     */
    private static $instance;

    /**
     * FPersistentManager constructor.
     */
    private function __construct() {}

    /**
     * @return FPersistentManager
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new FPersistentManager();
        }

        return self::$instance;
    }

    private function getClass(string $class){
        if($class === "EAdmin" || $class === "ERegistrato" || $class === "ENonRegistrato"){
            return "FUtente";
        } elseif($class == "EMediaLocandina" || $class == "EMediaUtente") {
            return "FMedia";
        } else if($class === "ESalaFisica") {
            return "FSala";
        }
        $class[0] = "F";
        return $class;
    }

    public function save($istanza) {
        $class = self::getClass(get_class($istanza));
        $class::save($istanza);
    }

    public function saveNS($utente, $preferenze) {
        FNewsLetter::save($utente, $preferenze);
    }

    public function saveProiezione(EProiezione $proiezione) {
        $result = FProiezione::save($proiezione);
        return $result;
    }

    public function load($value, $row, $class) {
        $class = self::getClass($class);
        return $class::load($value, $row);
    }

    public function loadbannati() {
        return FUtente::loadBannati();
    }

    public function loadLike($value, $row, $class) {
        $value = str_replace("'", "\'", $value);
        $class = self::getClass($class);
        return $class::loadLike($value, $row);
    }

    public function loadDebole($value, $row, $value2, $row2, $class) {
        $class = self::getClass($class);
        return $class::loadDoppio($value, $row, $value2, $row2);
    }

    public function loadBetween($inizio, $fine, $class) {
        $class = self::getClass($class);
        return $class::loadBetween($inizio, $fine);
    }

    public function loadAll($class) {
        $class = self::getClass($class);
        return $class::loadAll();
    }

    public function loadAllSF(): int {
        return FSala::nLoadAll();
    }

    public function delete($value, $row, $class): bool {
        $class = self::getClass($class);
        return $class::delete($value, $row);
    }

    public function deleteDebole($value, $row, $value2, $row2, $class): bool {
        $class = self::getClass($class);
        return $class::delete($value, $row, $value2, $row2);
    }

    public function update($value, $row, $newValue, $newRow, $class): bool {
        $class = self::getClass($class);
        return $class::update($value, $row, $newValue, $newRow);
    }

    public function updateDebole($value, $row, $value2, $row2, $newValue, $newRow, $class): bool {
        $class = $this::getClass($class);
        return $class::update($value, $row, $value2, $row2, $newValue, $newRow);
    }

    public function occupaPosti(array $biglietti) {
        return FProiezione::occupaPosti($biglietti);
    }

    public function liberaPosto($idProiezione, $posto, $emailUtente)  {
        return FProiezione::liberaPosto($idProiezione, $posto, $emailUtente);
    }

    public function login(string $value, string $password, bool $isMail) {
        return FUtente::login($value, $password, $isMail);
    }

    public function signup(EUtente $utente) {
        FUtente::save($utente);
    }

    public function updatePasswordUser(EUtente $utente) {
        FUtente::updatePwd($utente);
    }

    public function loadFilmByFilter($genere, float $votoInizio, float $votoFine, DateTime $annoInizio, DateTime $annoFine) {
        return FFilm::loadByFilter($genere, $votoInizio, $votoFine, $annoInizio, $annoFine);
    }

    public function isASub(ERegistrato $utente): bool{
        return FNewsLetter::isASub($utente);
    }
}