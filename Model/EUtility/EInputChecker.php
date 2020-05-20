<?php


class EInputChecker
{
    private static EInputChecker $instance;

    private function __construct() {}

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new EInputChecker();
        }
        return self::$instance;
    }

    public function username(string $username): bool {
        $res = preg_replace("/[^a-zA-Z]/", "", $username);
        if(strlen($username) < 8 || $res !== $username ) {
            return false;
        }
        return true;
    }

    public function password(string $password): bool {
        if(strlen($password) < 8) {
            return false;
        }
        return true;
    }

    public function email(string $email): bool {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public function date(string $date) {
        $elem = explode("-",$date);
        if(sizeof($elem) !== 3) {
            return false;
        }
        return checkdate($elem[1],$elem[2],$elem[0]);
    }

    public function hour(string $hour) {
        $res = strtotime($hour);
        if($res !== false){
            return true;
        }
        return $res;
    }
}