<?php
class CGiudizio{
    public static function add() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $pm = FPersistentManager::getInstance();
            $g = EHelper::getInstance();
            $idFilm = $_POST["film"];

            if (!CUtente::isLogged()) {
                header("Location: /Film/show/?film=" . $idFilm);
            }

            $utente = CUtente::getUtente();
            if ($utente->isAdmin()) {
                VError::error(0, "Un admin non può fare giudizi su un film.");
            } else {
                $checker = EInputChecker::getInstance();
                $commento = $checker->comment($_POST["commento"]);
                $titolo = $checker->title($_POST["titolo"]);
                $punteggio = $g->retrieveVote($_POST["punteggio"]);

                $film = $pm->load($idFilm, "id", "EFilm")[0];
                $data = new DateTime('now');

                $giudizio = new EGiudizio($commento, $punteggio, $film, $utente, $titolo, $data);
                $pm->save($giudizio);
                header("Location: /Film/show/?film=" . $idFilm . "&autoplay=true");
            }
        } else {
            header("Location: /");
        }
    }

    public static function delete() {
        if(CUtente::isLogged()) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $pm = FPersistentManager::getInstance();
                $idFilm = $_POST["film"];
                $idUtente = $_POST["utente"];

                $pm->deleteDebole($idFilm, "idFilm", $idUtente, "idUtente", "EGiudizio");
                if(!isset($_POST["redirect"])) {
                    header("Location: /Film/show/?film=" . $idFilm);
                } else {
                    header("Location: /Utente/showCommenti/");
                }
            } else {
                CMain::notFound();
            }
        } else {
            VError::error(6);
        }
    }
}