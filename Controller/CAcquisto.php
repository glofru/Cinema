<?php


class CAcquisto
{
    public static function getBiglietti() {
        if($_SERVER['REQUEST_METHOD']=="POST") {
            print_r($_POST);
        }
    }
}