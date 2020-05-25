<?php


class VFilm
{
    public static function show(EFilm $film, bool $autoplay, EMedia $copertina, array $filmconsigliati, array $imgconsigliati)
    {
        $smarty = StartSmarty::configuration();
        $smarty->assign("film", $film);
        $smarty->assign("consigli", $filmconsigliati);
        $smarty->assign("autoplay", $autoplay);
        $smarty->assign("locandina", $copertina);
        $smarty->assign("immagini", $imgconsigliati);
        $smarty->assign("registi", $film->getRegisti());
        $smarty->assign("attori", $film->getAttori());
        $smarty->display("film.tpl");
    }
}