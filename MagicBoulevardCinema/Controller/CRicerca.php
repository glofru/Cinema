<?php

/**
 * La classe Ricerca mette a disposizione i metodi necessari a poter processare le richieste formulate nell'utente nell'ambito della ricerca di film
 * sulla base di particolari criteri (Anno di rilascio, voto della critica, genere, nome)
 * Class CRicerca
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Controller
 */
class CRicerca
{
    /**
     * Funzione che permette la ricercra di un film tramite nome. Vengono restituiti tutti i film che contengono nel nome la parola chiave cercata.
     * Insieme ad i film vengono restituite anche le relative locandine.
     * @throws SmartyException
     */
    public static function cercaFilm() {
        if($_SERVER['REQUEST_METHOD']=="POST") {
            $str = $_POST["filmCercato"];

            if($str !== "") {
                $film = FPersistentManager::getInstance()->loadLike($str, "nome", "EFilm");
                $data = CFilm::getFilmData($film);
            } else {
                $film = [];
                $data = [];

                array_push($data, [], []);
            }
            $utente      = CUtente::getUtente();
            $consigliati = CUtility::getConsigliati($utente);

            VRicerca::showResult($film, $data[0], $data[1], $consigliati[0], $consigliati[1], $utente);
        }
        else {
            CFrontController::methodNotAllowed();
        }
    }

    /**
     * Funzione che permette di ricercare un film tramite il genere, l'anno di rilascio ed il voto della critica.
     * Vengono restituiti nella pagina i film con le relative locandine.
     */
    public static function cercaFilmAttributi() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $genere         = $_POST["genere"];
            $annoI          = $_POST["anno_inizio"];
            $annoF          = $_POST["anno_fine"];
            $votoInizio     = floatval($_POST["voto_inizio"]);
            $votoFine       = floatval($_POST["voto_fine"]);

            $annoInizio     = DateTime::createFromFormat('Y-m-d', $annoI . "-01-01");
            if ($annoInizio === false) {
                $annoInizio = new DateTime('now');
            }

            $annoFine       = DateTime::createFromFormat('Y-m-d', $annoF . "-12-31");
            if ($annoFine === false) {
                $annoFine   = new DateTime('now');
            }

            $film        = FPersistentManager::getInstance()->loadFilmByFilter(EGenere::fromString($genere), $votoInizio, $votoFine, $annoInizio, $annoFine);
            $data        = CFilm::getFilmData($film);

            $utente      = CUtente::getUtente();
            $consigliati = CUtility::getConsigliati($utente);


            VRicerca::showResult($film, $data[0], $data[1], $consigliati[0], $consigliati[1], $utente, $genere, $annoI, $annoF, $votoInizio, $votoFine);
        } else {
            CFrontController::methodNotAllowed();
        }
    }
}