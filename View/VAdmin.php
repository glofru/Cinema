<?php


class VAdmin
{
    private Smarty $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    public function addFilm($film = null, $riepilogo = false)
    {
        if ($film != null)
        {
            $this->smarty->assign("film", $film);
        }
        $this->smarty->assign("riepilogo", $riepilogo);
        $this->smarty->assign("generi", EGenere::getAll());
        $this->smarty->display("addFilm.tpl");
    }
}