<?php


class CFilm
{
    public static function show()
    {
        $pm = FPersistentManager::getInstance();
        $filmID = $_GET["film"];
        $autoplay = isset($_GET["autoplay"]) && $_GET["autoplay"];
        $film = $pm->load($filmID, "id", "EFilm")[0];
        $filmC = $pm->load($film->getGenere(),"Genere","EFilm");
        $locandine = [];
        foreach($filmC as $key => $f) {
            if ($f->getId() == $filmID) {
                echo '<br>'. $filmID . " " . $key . '<br>';
                unset($filmC[$key]);
            }
        }
        $filmC = array_values($filmC);
        if(sizeof($filmC) > 6){
            $filmC = array_slice($filmC,0,6);
        }
        $img = $pm->load($filmID,"idFilm","EMediaLocandina");
        foreach($filmC as $loc) {
            array_push($locandine,$pm->load($loc->getId(),"idFilm","EMediaLocandina"));
        }

        VFilm::show($film, $autoplay, $img, $filmC, $locandine);
    }
}