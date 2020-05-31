<?php
class CGiudizio{
    public static function add(){
        $pm = FPersistentManager::getInstance();
        $g = EHelper::getInstance();
        $id = $_POST["filmId"];

        if(!CUtente::isLogged()) {
            header("Location: /Film/show/?film=". $id);
        }

        $utente = CUtente::getUtente();
        if($utente->isAdmin()){
            VError::error(0, "UN ADMIN NON PUO' EFFETTUARE GIUDIZI SUI FILM!");
        } else {

            $checker = EInputChecker::getInstance();
            $commento = $checker->comment($_POST["commento"]);
            $titolo = $checker->title($_POST["titolo"]);
            $punteggio = $g->retrieveVote($_POST["punteggio"]);

            $film = $pm->load($id, "id", "EFilm")[0];
            $data = new DateTime('now');

            $giudizio = new EGiudizio($commento, $punteggio, $film, $utente, $titolo, $data);
            $pm->save($giudizio);
            header("Location: /Film/show/?film=" . $id . "&autoplay=true");
        }
    }
}
?>