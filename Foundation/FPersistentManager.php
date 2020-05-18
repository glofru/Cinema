<?php


/**
 * Class FPersistentManager
 */
class FPersistentManager
{
    /**
     * @var FPersistentManager
     */
    private static FPersistentManager $instance;

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

    public function store($istanza) {
        $class = get_class($istanza);
        $class[0] = "F";
        $class::save($istanza);
    }

    public function load($value,$row,$class) {
        return $class::load($value,$row);
    }

    public function loadDebole($value,$row,$value2,$row2,$class) {
        return $class::load($value,$row,$value2,$row2);
    }

    public function loadProiezioni($value,$row,$puntuale,$inizio,$fine,$class) {
        return $class::load($value,$row,$puntuale,$inizio,$fine);
    }

    public function delete($value,$row,$class) {
        $class::delete($value,$row);
    }

    public function deleteDebole($value,$row,$value2,$row2,$class) {
        $class::delete($value,$row,$value2,$row2);
    }

    public function update($value,$row,$newValue,$newRow,$class) {
        $class::update($value,$row,$newValue,$newRow);
    }

    public function updateDebole($value,$row,$value2,$row2,$newValue,$newRow,$class) {
        $class::update($value,$row,$value2,$row2,$newValue,$newRow);
    }


}