<?php


class VFilm
{
    public static function show(EFilm $film, bool $autoplay, EMedia $copertina, array $filmconsigliati, array $imgconsigliati, array $reviews, array $propic, array $pro, bool $canView, $utente)
    {
        $smarty = StartSmarty::configuration();
        $smarty->assign("film", $film);
        $smarty->assign("consigli", $filmconsigliati);
        $smarty->assign("autoplay", $autoplay);
        $smarty->assign("locandina", $copertina);
        $smarty->assign("immagini", $imgconsigliati);
        $smarty->assign("registi", $film->getRegisti());
        $smarty->assign("attori", $film->getAttori());
        $smarty->assign("recensioni", $reviews);
        $smarty->assign("propic", $propic);
        $smarty->assign("attori", $film->getAttori());
        $smarty->assign("canView", $canView);
        $smarty->assign("proiezioni", $pro);
        $smarty->assign("utente", $utente);
        $smarty->display("film.tpl");
    }
}