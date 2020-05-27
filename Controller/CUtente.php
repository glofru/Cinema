<?php


class CUtente
{
    static function login (){
        if($_SERVER['REQUEST_METHOD']=="GET"){
            if(static::isloggato()) {
                $pm = new FPersistentManager();
                $view = new VUtente();
                $view->loginOk();
            }
            else{
                $view=new VUtente();
                $view->showFormLogin();
            }
        }elseif ($_SERVER['REQUEST_METHOD']=="POST")
            static::verificautente();
    }
    static function logout(){
        session_start();
        session_unset();
        session_destroy();
        header('Location: /Cinema/Utente/login');
    }

    public function error() {
        $view = new VError();
        $view->error('1');
    }

    static function verificautente() {
        $view = new VUtente();
        $pm = FPersistentManager::getInstance();
        $utente = $pm->login($_POST['username'],$_POST['emailutente'] , $_POST['password']);
        if ($utente != null && $utente->getState() != false) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
                $salvare = serialize($utente);
                $_SESSION['utente'] = $salvare;
                if ($_POST['email'] != 'emailadmin') {
                    header('Location: /Cinema/Home');//indirizzamento tramite cookie?
                }
                else {
                    header('Location: /Cinema/Admin/homepage');
                }
            }
        }
        else {
            $view->loginError();
        }
    }

    static function isloggato() {
        $identificato = false;
        if (isset($_COOKIE['PHPSESSID'])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
        if (isset($_SESSION['utente'])) {
            $identificato = true;
        }
        return $identificato;
    }



}