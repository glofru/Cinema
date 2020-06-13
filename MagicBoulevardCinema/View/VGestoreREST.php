<?php

/**
 * La classe GestoreREST permette di ottenere come risultato degli oggetti espressi in formato JSON.
 * Class VGestoreREST
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package View
 */
class VGestoreREST
{
    /**
     * Funzione che, dato un oggetto, restuisce gli attributi dell'oggetto in formato JSON.
     * @param $json, oggetto da cui estrarre i dati in formato JSON.
     */
    public static function showJSON($json) {
        header('Content-Type: application/json');
        echo json_encode($json);
    }

    /**
     * Funzione che permette, dato un array, per ogni elemento di ottenere gli attributi di questi in formato JSON.
     * @param array $array, array dal quale ottenere, per ogni oggetto, gli attributi in formato JSON.
     */
    public static function showJSONArray(array $array) {
        header('Content-Type: application/json');
        foreach ($array as $item) {
            echo json_encode($item);
        }
    }
}