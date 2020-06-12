<?php
class CGiudizio{
    public static function add() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (!CUtente::isLogged()) {
                CMain::forbidden();
            }

            $utente = CUtente::getUtente();
            if ($utente->isAdmin()) {
                VError::error(0, "Un admin non può esprimere giudizi su un film.");
            } else {
                $pm = FPersistentManager::getInstance();

                $commento = $_POST["commento"]??"";
                $titolo = $_POST["titolo"]??"";
                $punteggio = floatval($_POST["punteggio"]);
                $idFilm = $_POST["film"];

                $film = $pm->load($idFilm, "id", "EFilm")[0];

                $data = new DateTime('now');

                $giudizio = new EGiudizio($commento, $punteggio, $film, $utente, $titolo, $data);

                $pm->save($giudizio);
                $utente->addGiudizio($giudizio);
                CUtente::saveSession($utente);
                header("Location: /Film/show/?film=" . $idFilm);
            }
        } else {
            CMain::methodNotAllowed();
        }
    }

    public static function delete() {
        if(CUtente::isLogged()) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $pm = FPersistentManager::getInstance();
                $idFilm = $_POST["film"];
                $idUtente = $_POST["utente"];
                $giudizio = $pm->loadDebole($idFilm, "idFilm", $idUtente, "idUtente", "EGiudizio");
                $pm->deleteDebole($idFilm, "idFilm", $idUtente, "idUtente", "EGiudizio");
                $utente = CUtente::getUtente();
                $utente->removeGiudizio($giudizio);
                $_SESSION["utente"] = serialize($utente);
                if(!isset($_POST["redirect"])) {
                    header("Location: /Film/show/?film=" . $idFilm);
                } else {
                    header("Location: /Utente/showCommenti/");
                }
            } else {
                CMain::methodNotAllowed();
            }
        } else {
            CMain::forbidden();
        }
    }
}