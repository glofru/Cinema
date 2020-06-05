<?php


class VGestoreREST
{
    public static function showJSON($json) {
        header('Content-Type: application/json');
        echo json_encode($json);
    }

    public static function showJSONArray(array $array) {
        header('Content-Type: application/json');
        foreach ($array as $item) {
            echo json_encode($item);
        }
    }
}