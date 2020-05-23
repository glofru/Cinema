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
        $this->smarty->display("home.tpl");
    }
}