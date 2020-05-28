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
        }
        $class[0] = "F";
        return $class;
    }

    public function save($istanza) {
        $class = self::getClass(get_class($istanza));
        $class::save($istanza);
    }

    public function saveProiezione(EProiezione $proiezione) {
        $result = FProiezione::save($proiezione);
        return $result;
    }

    public function load($value, $row ,$class) {
        $class = self::getClass($class);
        return $class::load($value,$row);
    }

    public function loadLike($value, $row, $class) {
        $class = self::getClass($class);
        return $class::loadLike($value,$row);
    }

    public function loadDebole($value, $row, $value2, $row2, $class) {
        $class = self::getClass($class);
        return $class::loadDoppio($value, $row, $value2, $row2);
    }

    public function loadBetween($inizio, $fine, $class) {
        $class = self::getClass($class);
        return $class::loadBetween($inizio, $fine);
    }

    public function delete($value, $row, $class) {
        $class = self::getClass($class);
        $class::delete($value, $row);
    }

    public function deleteDebole($value, $row, $value2, $row2, $class) {
        $class = self::getClass($class);
        $class::delete($value, $row, $value2, $row2);
    }

    public function update($value, $row, $newValue, $newRow, $class) {
        $class = self::getClass($class);
        $class::update($value, $row, $newValue, $newRow);
    }

    public function updateDebole($value, $row, $value2, $row2, $newValue, $newRow, $class) {
        $class = $this::getClass($class);
        $class::update($value, $row, $value2, $row2, $newValue, $newRow);
    }

    public function occupaPosto(EProiezione $proiezione, EPosto $posto, EUtente $utente, int $costo) {
        return FProiezione::occupaPosto($proiezione, $posto, $utente, $costo);
    }

    public function liberaPosto($idProiezione, $posto, $emailUtente)  {
        return FProiezione::liberaPosto($idProiezione, $posto, $emailUtente);
    }

    public function login(string $value, string $password, bool $isMail){
        return FUtente::login($value, $password, $isMail);
    }
}