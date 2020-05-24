<?php


class VFilm
{
    private Smarty $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    public function show(EFilm $film, bool $autoplay, EMedia $img, array $filmconsigliati, array $imgconsigliati)
    {
        $this->smarty->assign("film", $film);
        $this->smarty->assign("consigli", $filmconsigliati);
        $this->smarty->assign("autoplay", $autoplay);
        $this->smarty->assign("locandina", $img);
        $this->smarty->assign("immagini", $imgconsigliati);
        $this->smarty->assign("registi", $film->getRegisti());
        $this->smarty->assign("attori", $film->getAttori());
        $this->smarty->display("film.tpl");
    }
}