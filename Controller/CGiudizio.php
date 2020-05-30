<?php
class CGiudizio{
    public static function add(){
        $pm = FPersistentManager::getInstance();
        $g = EHelper::getInstance();
        $id = $_POST["filmId"];
        $utente = CUtente::getUtente();
        if(!isset($utente)) {
            header("Location: /Film/show/?film=". $id . "&autoplay=true");
        }
        $checker = EInputChecker::getInstance();
        $commento = $checker->comment($_POST["commento"]);
        $titolo = $checker->title($_POST["titolo"]);
        $punteggio = $g->retrieveVote($_POST["punteggio"]);
        $film = $pm->load($id,"id","EFilm")[0];
        $data = new DateTime('now');
        $giudizio = new EGiudizio($commento, $punteggio, $film, $utente, $titolo, $data);
        $pm->save($giudizio);
        header("Location: /Film/show/?film=". $id . "&autoplay=true");
    }
}
?>