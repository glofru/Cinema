<?php
class CGiudizio{
    public static function add(){
        $pm = FPersistentManager::getInstance();
        $g = EHelper::getInstance();
        $id = $_POST["filmId"];
        $utente = $g->getUtente();
        if($utente == false){
            header("Location: Utente/logout");
        }
        if(!isset($utente)) {
            header("Location: /Film/show/?film=". $id . "&autoplay=true");
        }
        $commento = $_POST["commento"];
        $titolo = $_POST["titolo"];
        $punteggio = $g->retriveVote($_POST["punteggio"]);
        $film = $pm->load($id,"id","EFilm")[0];
        $data = new DateTime('now');
        $giudizio = new EGiudizio($commento, $punteggio, $film, $utente, $titolo, $data);
        $pm->save($giudizio);
        header("Location: /Film/show/?film=". $id . "&autoplay=true");
    }
}
?>