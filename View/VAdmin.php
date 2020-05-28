<?php


class VAdmin
{
    public static function addFilm(array $attori, array $registi)
    {
        $smarty = StartSmarty::configuration();
        $smarty->assign("attori", $attori);
        $smarty->assign("registi", $registi);
        $smarty->assign("generi", EGenere::getAll());
        $smarty->display("addFilm.tpl");
    }
}