<?php


class ENewsLetter
{
    private array $listaUtenti;
    private array $listaPreferenze;

    public function __construct()
    {
        $this->listaUtenti = array();
        $this->listaPreferenze = array();
    }

    public function addUtentePreferenze(ERegistrato $utente, array $preferenze = null) {
        array_push($this->listaUtenti, $utente);
        array_push($this->listaPreferenze, $preferenze);
    }

    public function getListaUtenticonPreferenze(): array {
        $result = [];
        array_push($result, $this->listaUtenti, $this->listaPreferenze);
        return $result;
    }

    public function modifyPreferenze(ERegistrato $utente, array $newPreferenze): bool {
        $value = array_search($utente, $this->listaUtenti);
        if($value !== false) {
            $this->listaPreferenze[$value] = $newPreferenze;
            return true;
        } else {
            return false;
        }
    }

    public function removeUtente(ERegistrato $utente): bool {
        $value = array_search($utente, $this->listaUtenti);
        if($value !== false) {
            unset($this->listaUtenti[$value]);
            unset($this->listaPreferenze[$value]);
            $this->listaUtenti = array_values($this->listaUtenti);
            $this->listaPreferenze = array_values($this->listaPreferenze);
            return true;
        } else {
            return false;
        }
    }

    public function preferencesDB(ERegistrato $utente) {
        $value = array_search($utente, $this->listaUtenti);
        $res = "";
        if($value !== false) {
            foreach ($this->listaPreferenze[$value] as $item) {
                $res .= $item . ";";
            }
            return substr($res, 0, -1);
        } else {
            return "";
        }
    }

    public function addUtenteEPreferenzaFromRaw(ERegistrato $utente, string $prefs) {
        if($prefs === "") {
            array_push($arr, null);
        } else {
            $res = explode(";", $prefs);
            $arr = [];
            foreach ($res as $str) {
                array_push($arr, EGenere::fromString($str));
            }
        }
        $this->addUtentePreferenze($utente, $arr);
    }



}