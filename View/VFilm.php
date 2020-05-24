<?php


class VFilm
{
    private Smarty $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    public function show(EFilm $film)
    {
        $this->smarty->assign("film", $film);
        $this->smarty->display("film.tpl");
    }
}