<?php

/**
 * Interfaccia alla quale si appoggiano tutte le classi Foundation che sono entità non deboli. Contiene solo i metodi CRUD.
 * @author Lofrumento - Di Santo - Susanna
 * @package Foundation
 */
interface Foundation
{
    /**
     * Funzione che permette di eseguire il Binding della query con i particolari valori dell'oggetto che si vuole salvare.
     * @param PDOStatement $sender
     * @param $object, oggetto dal quale si vogliono prelevare i valori.
     * @return mixed
     */
    public static function associate(PDOStatement $sender, $object);

    /**
     * Funzione che permette di caricare un oggetto dal DB dati un valori ed una colonna. Ritorna un array con i valori che corrispondono alla ricerca.
     * @param string $value, valore da usare per identificare l'oggetto.
     * @param string $row, colonna nella quale cercare il valore.
     * @return mixed, insieme delle righe risultanti.
     */
    public static function load(string $value, string $row);

    /**
     * Funzione che permette di aggiornare un oggetto nel DB sulla base di un valore ed una colonna. Ritorna l'esito dell'operazione
     * @param $value, valore necessario ad indetificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @param $newvalue, valore che si vuole inserire.
     * @param $newrow, colonna nella quale inserire il nuovo valore.
     * @return mixed, risultato dell'operazione.
     */
    public static function update($value, $row, $newvalue, $newrow);

    /**
     * Funzione che pemrette di eliminare un oggetto dal DB sulla base di un valore ed una colonna. Ritorna l'esito dell'operazione
     * @param $value, valore da usare per identificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @return mixed, insieme delle righe risultanti.
     */
    public static function delete($value, $row);
}