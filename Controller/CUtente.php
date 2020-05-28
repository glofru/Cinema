<?php


class CUtente
{
    public static function loginForm(){
        if($_SERVER['REQUEST_METHOD']=="GET"){
			if(isset($_COOKIE["PHPSESSID"])) {
			    session_start();
                $user = unserialize($_SESSION["utente"]);
                //showuser($user);
			}
			else{
				VUtente::loginForm();
			}
        }
        elseif ($_SERVER['REQUEST_METHOD']=="POST")
			self::checkLogin();
    }
    
    static function logout(){
        if(isset($_COOKIE["PHPSESSID"])) {
            session_start();
            session_unset();
            session_destroy();
            setcookie("PHPSESSID","", time() - 3600,"/");
        }
        header("Location: /");
    }

    public function error() {
        VError::error('1');
    }

    private static function checkLogin() {
        $view = new VUtente();
        $pm = FPersistentManager::getInstance();
        $value = $_POST['log'];
        $gestore = EInputChecker::getInstance();
        if($value === $gestore->username($value)) {
            $isMail = false;
        }
        else if ($value === $gestore->email($value)) {
            $isMail = true;
        }
        else {
            $isMail = false;
            $value = "";
        }
        $utente = $pm->login($value, $_POST['password'],$isMail);
        if (sizeof($utente) != 0) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
                session_regenerate_id(true);
                session_set_cookie_params(3600,"/",null,false,false);
                $salvare = serialize($utente);
                $_SESSION['utente'] = $salvare;
                /*if ($utente->isAdmin() === true) {
                    header('Location: /Cinema/Home');
                }
                else {*/
                    header('Location: /');
                //}
            }
            else {
                $view->loginError();
                header('Location: /');
            }
        }
        else {
            header('Location: /Utente/loginForm');
        }
    }
    
    public static function mostraprofilo() {
        $view = new VUtente();
        $pm = FPersistentManager::getInstance();
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if (CUtente::isloggato()) {
                $utente = unserialize($_SESSION['utente']);
                if (get_class($utente) == "ERegistrato") {
                    $img = $pm->load("emailutente", $utente->getEmail(), "FUtente");
                    $annunci = $pm->load("emailWriter", $utente->getEmail(), "FAnnuncio");
                    $view->profileCli($utente, $annunci, $img);
                } else {
                    $img = $pm->load("emailutente", $utente->getEmail(), "FMediaUtente");
                    $annunci = $pm->load("emailWriter", $utente->getEmail(), "FAnnuncio");
                    list ($imgMezzo,$imgrecensioni) = static::set_profilo_tra($utente);
                    $rec = static::info_cliente_rec($utente);
                    $view->profileTrasp($utente, $annunci, $img, $imgMezzo, $imgrecensioni,$rec);
                }
            } else
                header('Location: /Cinema/Utente/login');
        }
    }

    public static function registrazioneUtente(){
        if($_SERVER['REQUEST_METHOD']=="GET") {
            $view = new VUtente();
            $pm = FPersistentManager::getInstance();
            if (static::checkLogin()) {
                $pm->load();
            }
            else {
                $view->registra_cliente();
            }
        }else if($_SERVER['REQUEST_METHOD']=="POST") {
            static::regist_cliente_verifica();
        }
    }



}