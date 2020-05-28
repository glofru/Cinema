<?php
class CGiudizio{
    public static function add(){
        /*if(!isset($SESSION_["user"])){
            header("Location: /");
        }*/
        $pm = FPersistentManager::getInstance();
        $g = EHelper::getInstance();
        $user = $pm->load(/*$SESSION_["userID"]*/1,"id","EUtente");
        $commento = $_POST["commento"];
        $titolo = $_POST["titolo"];
        $punteggio = $g->retriveVote($_POST["punteggio"]);
        $id = $_POST["filmId"];
        $film = $pm->load($id,"id","EFilm")[0];
        $data = new DateTime('now');
        $giudizio = new EGiudizio($commento, $punteggio, $film, $user, $titolo, $data);
        $pm->save($giudizio);
        header("Location: /Film/show/?film=". $id . "&autoplay=true");
    }
}
?>