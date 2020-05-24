<?php


class CFilm
{
    public static function show()
    {
        $pm = FPersistentManager::getInstance();
        $filmID = $_GET["film"];
        $autoplay = isset($_GET["autoplay"]) && $_GET["autoplay"];
        $film = $pm->load($filmID, "id", "EFilm")[0];
        $img = $pm->load($filmID,"idFilm","EMediaLocandina");
        $vfilm = new VFilm();
        $vfilm->show($film, $autoplay, $img);
    }
}