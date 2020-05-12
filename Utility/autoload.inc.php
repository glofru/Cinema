<?php
function autoloader_view($class){
    include_once('../View/' . $class . '.php');
}

function autoloader_control($class){
    include_once('../Control/' . $class . '.php');
}

function autoloader_model($class){
    include_once('../Model/' . $class  . '.php');
}

function autoloader_foundation($class){
    include_once('../Foundation/' . $class  . '.php');
}

spl_autoload_register('autoloader_view');
spl_autoload_register('autoloader_control');
spl_autoload_register('autoloader_model');
spl_autoload_register('autoloader_foundation');

?>