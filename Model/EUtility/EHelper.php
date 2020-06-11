<?php


class EHelper
{
    private static $instance;

    private function __construct() {}

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new EHelper();
        }
        return self::$instance;
    }

    public function preferences ($cookie) {
        if(!isset($cookie)) {
            $value = [];
            $generi = EGenere::getAll();
            foreach ($generi as $key) {
                $value[$key] = 0;
            }
            $value = serialize($value);
            setcookie('preferences', $value, time() + (86400 * 30), "/");
        }
        $value = unserialize($cookie);
        return $value;
    }

    public function getPreferences($arr) {
        $isEmpty = true;
        $temp_values = [];
        $all = 0;
        foreach($arr as $key => $a) {
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

    public function setPreferences(string $genere, $cookie) {
        $cookie[$genere]++;
        $cookie = serialize($cookie);
        setcookie('preferences', $cookie, time() + (86400 * 30), "/");
    }

}