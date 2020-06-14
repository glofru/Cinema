<?php

/**
 * La classe Giudizio contiene i metodo necessari a poter aggiungere e cancellare un giudizio espresso da un utente Registrato.
 * Class CGiudizio
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Controller
 */
class CGiudizio{
    /**
     *Funzione, accessibile solo tramite metodo POST, che permette di poter creare un oggetto giudizio, aggiungerlo alla lista dei giudizi espressi dall'utente e salvare l'oggetto nel DB.
     * Solo un utente registrato può esrimere un giudizio!
     * @throws SmartyException
     */
    public static function add() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (!CUtente::isLogged()) {
                CMain::unauthorized();
            }

            $utente = CUtente::getUtente();
            if ($utente->isAdmin()) {
                VError::error(0, "Un admin non può esprimere giudizi su un film.");
            } else {
                $pm = FPersistentManager::getInstance();

                $commento   = $_POST["commento"]??"";
                $titolo     = $_POST["titolo"]??"";
                $punteggio  = floatval($_POST["punteggio"]);
                $idFilm     = $_POST["film"];

                $film       = $pm->load($idFilm, "id", "EFilm")[0];

                $data       = new DateTime('now');

                $giudizio   = new EGiudizio($commento, $punteggio, $film, $utente, $titolo, $data);

                $pm->save($giudizio);
                $utente->addGiudizio($giudizio);
                CUtente::saveSession($utente);

                header("Location: /MagicBoulevardCinema/Film/show/?film=" . $idFilm);
            }
        } else {
            CMain::methodNotAllowed();
        }
    }

    /**
     * Funzione che permette di cancellare un giudizio espresso da un utente Registrato. Questo viene eliminato dall'insieme dei giudizi espresso dall'utente e rimosso dalla persistenza.
     * Questa funzione è accessibile solo attraverso due pagine (pagina dle film e pagina dei commenti dell'utente).
     * Si viene, quindi, reindirizzati alla pagina dalla quale è stata effettuata la richiesta di eliminazione.
     * @throws SmartyException
     */
    public static function delete() {
        if(CUtente::isLogged()) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $pm = FPersistentManager::getInstance();

                $utente   = CUtente::getUtente();
                $idFilm   = $_POST["film"];
                $idUtente = $_POST["utente"];

                $giudizio = $pm->loadDebole($idFilm, "idFilm", $idUtente, "idUtente", "EGiudizio");
                $pm->deleteDebole($idFilm, "idFilm", $idUtente, "idUtente", "EGiudizio");
                if(!$utente->isAdmin()) {
                    $utente->removeGiudizio($giudizio);
                }
                CUtente::saveSession($utente);

                if(!isset($_POST["redirect"])) {
                    header("Location: /MagicBoulevardCinema/Film/show/?film=" . $idFilm);
                } else {
                    header("Location: /MagicBoulevardCinema/Utente/showCommenti/");
                }
            } else {
                CMain::methodNotAllowed();
            }
        } else {
            CMain::unauthorized();
        }
    }
}