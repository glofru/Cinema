<?php


class CFilm
{
    public static function show($filmId)
    {
        $pm = FPersistentManager::getInstance();
        $film = $pm->load($filmId, "id", "EFilm")[0];
        $vfilm = new VFilm();
        $vfilm->show($film);
    }
}