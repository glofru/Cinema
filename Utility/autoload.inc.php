<?php
function autoloader_view($class){
    include_once('../View/' . $class . '.php');
}

function autoloader_control($class){
    include_once('../Control/' . $class . '.php');
}

function autoloader_model($class){
    include_once('../Model/EFilm/' . $class  . '.php');
    include_once('../Model/EForum/' . $class  . '.php');
    include_once('../Model/EMedia/' . $class  . '.php');
    include_once('../Model/EPrenotazione/' . $class  . '.php');
    include_once('../Model/EProgrammazioneFilm/' . $class  . '.php');
    include_once('../Model/ESale/' . $class  . '.php');
    include_once('../Model/EUtenti/' . $class  . '.php');
}

function autoloader_foundation($class){
    include_once('../Foundation/BaseFoundation/' . $class  . '.php');
    include_once('../Foundation/Database/' . $class  . '.php');
    include_once('../Foundation/FFilm/' . $class  . '.php');
    include_once('../Foundation/FForum/' . $class  . '.php');
    include_once('../Foundation/FMedia/' . $class  . '.php');
    include_once('../Foundation/FPrenotazione/' . $class  . '.php');
    include_once('../Foundation/FPrenotazioneFilm/' . $class  . '.php');
    include_once('../Foundation/FSale/' . $class  . '.php');
    include_once('../Foundation/FUtente/' . $class  . '.php');
}

spl_autoload_register('autoloader_view');
spl_autoload_register('autoloader_control');
spl_autoload_register('autoloader_model');
spl_autoload_register('autoloader_foundation');

?>