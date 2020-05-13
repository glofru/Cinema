<?php


/**
 * Class FDatabase
 */
class FDatabase
{
    /**
     * @var FDatabase
     */
    private static FDatabase $instance;

    /**
     * FDatabase constructor.
     */
    private function __construct() {}

    /**
     * @return FDatabase
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new FDatabase();
        }

        return self::$instance;
    }
}