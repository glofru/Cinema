<?php
class CGiudizio{
    public static function add(){
        /*if(!isset($SESSION_["userID"])){
            header("Location: /");
        }*/
        $pm = FPersistentManager::getInstance();
        $user = $pm->load(/*$SESSION_["userID"]*/1,"id","EUtente");
        $commento = $_POST["commento"];
        $titolo = $_POST["titolo"];
        echo $titolo . " PT: " . $_POST["punteggio"];
        //$punteggio = floatval($_POST["punteggio"]);
        //$film = $pm->load($_POST["filmId"],"id","EFilm")[0];
        //$giudizio = new EGiudizio($commento,$punteggio,$film,$user,$titolo);
        //$pm->store($giudizio);
        //header("Refresh:0");
    }
}
?>