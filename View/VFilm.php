<?php


class VFilm
{
    private Smarty $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    public function show(EFilm $film, bool $autoplay)
    {
        $this->smarty->assign("film", $film);
        $this->smarty->assign("autoplay", $autoplay);
        $this->smarty->display("film.tpl");
    }
}