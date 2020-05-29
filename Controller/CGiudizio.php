<?php
class CGiudizio{
    public static function add(){
        $pm = FPersistentManager::getInstance();
        $g = EHelper::getInstance();
        $id = $_POST["filmId"];
        if(isset($_COOKIE["PHPSESSID"])) {
            session_start();
            if(isset($_SESSION["utente"])) {
                $utente = unserialize($_SESSION["utente"]);
            }
            else {
                CUtente::logout();
            }
        }
        else
        {
            header("Location: /Film/show/?film=". $id . "&autoplay=true");
        }
        $commento = $_POST["commento"];
        $titolo = $_POST["titolo"];
        $punteggio = $g->retriveVote($_POST["punteggio"]);
        echo $punteggio;
        $film = $pm->load($id,"id","EFilm")[0];
        $data = new DateTime('now');
        $giudizio = new EGiudizio($commento, $punteggio, $film, $utente, $titolo, $data);
        $pm->save($giudizio);
        header("Location: /Film/show/?film=". $id . "&autoplay=true");
    }
}
?>