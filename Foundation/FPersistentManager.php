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
}