<?php

/**
 * Nella classe Visitatore sono presenti tutti i metodi e gli attributi necessari alla creazione Utente visitatore.
 * Class EVisitatore
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EVisitatore extends EUtente
{
    /**
     * EVisitatore constructor.
     * @throws Exception, se almeno uno dei parametri passato al costruttore non rispetta la relativa sintassi.
     */
    public function __construct()
    {
        parent::__construct("", "", "", "", "", false);
    }

    /**
     * @return array|mixed|void, funzione che serializza il contenuto della classe in formato JSON, necessario per rendere l'applicazione RESTFULL.
     */
    public function jsonSerialize()
    {
        return parent::jsonSerialize();
    }
}