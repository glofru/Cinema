<?php


class VHome
{
    private Smarty $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    public function home()
    {
        $pm = FPersistentManager::getInstance();
        $film1 = $pm->load("2", "id", "EFilm")[0];
        $film2 = $pm->load("3", "id", "EFilm")[0];
        $film = [];
        array_push($film, $film1, $film2);
        $this->smarty->assign("array", $film);
        $this->smarty->display("home.tpl");
    }
}