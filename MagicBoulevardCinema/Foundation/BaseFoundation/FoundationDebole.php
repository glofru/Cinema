<?php

/**
 * Interfaccia alla quale si appoggiano tutte le classi Foundation che sono entità deboli. Contiene solo i metodi CRUD, implementati in maniera differente per ogni classe.
 * @author Lofrumento - Di Santo - Susanna
 * @package Foundation
 */
interface FoundationDebole
{
    /**
     * Funzione che permette di eseguire il Binding della query con i particolari valori dell'oggetto che si vuole salvare.
     * @param PDOStatement $sender
     * @param $object1, oggetto dal quale si vogliono prelevare i valori.
     * @param $object2, oggetto dal quale si vogliono prelevare i valori.
     * @return mixed
     */
    public static function associate(PDOStatement $sender, $object1, $object2);

    /**
     * Funzione che permette di caricare un oggetto dal DB dati un valore ed una colonna. Ritorna un array con i valori che corrispondono alla ricerca.
     * @param string $value, valore da usare per identificare l'oggetto.
     * @param string $row, colonna nella quale cercare il valore.
     * @return mixed, insieme delle righe risultanti.
     */
    public static function load(string $value, string $row);

    /**
     * Funzione che permette di aggiornare un oggetto nel DB sulla base di un valore ed una colonna. Ritorna l'esito dell'operazione
     * @param $value, valore necessario ad indentificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @param $value2, secondo valore necessario ad indentificare l'oggetto.
     * @param $row2, secondo valore necessario ad indentificare l'oggetto.
     * @param $newvalue, valore che si vuole inserire.
     * @param $newrow, colonna nella quale inserire il nuovo valore.
     * @return mixed, risultato dell'operazione.
     */
    public static function update($value, $row, $value2, $row2, $newvalue, $newrow);

    /**
     * Funzione che pemrette di eliminare un oggetto dal DB sulla base di un valore ed una colonna. Ritorna l'esito dell'operazione
     * @param $value, valore da usare per identificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @param $value2, secondo valore necessario ad indentificare l'oggetto.
     * @param $row2, secondo valore necessario ad indentificare l'oggetto.
     * @return mixed, insieme delle righe risultanti.
     */
    public static function delete($value, $row, $value2, $row2);
}