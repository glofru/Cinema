<?php

/**
 * La classe Home contiene un metodo necessario a poter reperire tutti gli oggetti necessari (film, locandine e proiezioni) a dover essere visualizzati nella nostra pagina principale.
 * Class CHome
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Controller
 */
class CHome
{
    /**
     * Funzione che, accessibile solo tramite metodo GET, permette di reperire film proiezioni e locandine. Vengono, quindi, recuperati alcuni film di prossima uscita,
     * film che sono stati proiettati nella settimana scora, in questa, e saranno proiettati nella prossima settimana, ed i film consigliati sulla base delle visite effettuate dall'utente.
     * @throws SmartyException
     */
    public static function showHome() {
        if($_SERVER["REQUEST_METHOD"] === "GET"){
            $utente      = CUtente::getUtente(); //prende lutente
            $prossimi    = CUtility::getProssimi(5);//cutility contiene dei metodi di aiuto
            $consigliati = CUtility::getConsigliati($utente);
            $proiezioni  = CUtility::getProiezioni(EData::getSettimana());
            $prossima    = CUtility::getProiezioni(EData::getSettimanaProssima());
            $scorsa      = CUtility::getProiezioni(EData::getSettimanaScorsa(1)); //1 indica le settimane

            VHome::showHome($prossimi[0], $prossimi[1], $consigliati[0], $consigliati[1], $proiezioni[0], $proiezioni[1], $proiezioni[2], $proiezioni[3], $scorsa[0], $scorsa[1], $scorsa[2], $scorsa[3], $prossima[0], $prossima[1], $prossima[2], $prossima[3], $utente);
        } else {
            CMain::methodNotAllowed();
        }
    }
}