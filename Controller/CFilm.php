<?php
class CFilm
{
    public static function show()
    {
        $pm = FPersistentManager::getInstance();
        $filmID = $_GET["film"];
        $autoplay = isset($_GET["autoplay"]) && $_GET["autoplay"];
        $film = $pm->load($filmID, "id", "EFilm")[0];
        $gestore = EHelper::getInstance();
        $cookie = $gestore->preferences($_COOKIE['preferences']);
        $gestore->setPreferences($film->getGenere(),$cookie);
        unset($cookie);
        $filmC = $pm->load($film->getGenere(),"Genere","EFilm");

        foreach($filmC as $key => $f) {
            if ($f->getId() == $filmID) {
                unset($filmC[$key]);
            }
        }
        $filmC = array_values($filmC);
        if(sizeof($filmC) > 6){
            $filmC = array_slice($filmC,0,6);
        }

        $copertina = $pm->load($filmID,"idFilm","EMediaLocandina");

        $locandine = [];
        foreach($filmC as $loc) {
            array_push($locandine,$pm->load($loc->getId(),"idFilm","EMediaLocandina"));
        }

        VFilm::show($film, $autoplay, $copertina, $filmC, $locandine);
    }
}