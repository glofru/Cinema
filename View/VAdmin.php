<?php


class VAdmin
{
    public static function addFilm($film = null, $riepilogo = false)
    {
        $smarty = StartSmarty::configuration();
        if ($film != null)
        {
            $smarty->assign("film", $film);
        }
        $smarty->assign("riepilogo", $riepilogo);
        $smarty->assign("generi", EGenere::getAll());
        $smarty->display("addFilm.tpl");
    }
}