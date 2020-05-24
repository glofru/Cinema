<?php


class VFilm
{
    private Smarty $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    public function show(EFilm $film, bool $autoplay, EMedia $img)
    {
        $this->smarty->assign("film", $film);
        $this->smarty->assign("autoplay", $autoplay);
        $this->smarty->assign("locandina", $img);
        $this->smarty->assign("registi", $film->getRegisti());
        $this->smarty->display("film.tpl");
    }
}