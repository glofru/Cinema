<?php

require('Smarty/Smarty.class.php');

class StartSmarty{
    static function configuration(){
        $smarty = new Smarty();
        $smarty->setTemplateDir("Smarty/templates/");
        $smarty->setCompileDir("Smarty/templates_c");
//        $smarty->template_dir='Smarty/templates/';
//        $smarty->compile_dir='Smarty/templates_c/';
//        $smarty->config_dir='Smarty/configs/';
//        $smarty->cache_dir='Smarty/cache/';
        return $smarty;
    }
}
