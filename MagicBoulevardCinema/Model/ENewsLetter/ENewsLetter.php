<?php

/**
 * Nella classe NewsLetter sono presenti tutti i metodi e gli attributi necessari alla creazione e gestione della newsletter.
 * Class ENewsLetter
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class ENewsLetter implements JsonSerializable
{
    /**
     * Insieme degli utenti registrati alla NewsLetter.
     * @var array
     */
    private array $listaUtenti;

    /**
     * Insieme delle prefrenze di ciascun utente iscritto. Ovvero i generi preferiti dall'utente.
     * @var array
     */
    private array $listaPreferenze;

    /**
     * ENewsLetter constructor.
     */
    public function __construct()
    {
        $this->listaUtenti = array();
        $this->listaPreferenze = array();
    }

    /**
     * @param ERegistrato $utente, utente che si registra alla newsletter.
     * @param array|null $preferenze, insieme delle preferenze sui generi che l'utente ha fornito in fase di compilazione dle form.
     */
    public function addUtentePreferenze(ERegistrato $utente, array $preferenze = null) {
        array_push($this->listaUtenti, $utente);
        array_push($this->listaPreferenze, $preferenze);
    }

    /**
     * @return array, array contenente tutti gli utenti e le rispettive preferenze.
     */
    public function getListaUtenticonPreferenze(): array {
        $result = [];
        array_push($result, $this->listaUtenti, $this->listaPreferenze);
        return $result;
    }

    /**
     * Funzione che permette la modifica delle preferenze di un utente.
     * @param ERegistrato $utente, utente al quale modifcicare le prefernze
     * @param array $newPreferenze, le nuove preferenze espresse dall'utente.
     * @return bool, ritorna esito positivo se l'utente è iscritto alla newsletter e si è quindi potuto procedere alla modifica delle preferenze.
     */
    public function modifyPreferenze(ERegistrato $utente, array $newPreferenze): bool {
        $value = array_search($utente, $this->listaUtenti);
        if($value !== false) {
            $this->listaPreferenze[$value] = $newPreferenze;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param ERegistrato $utente
     * @return bool
     */
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

    /**
     * Funzione che ritorna le preferenze di un utente in un formato adatto ad essere immagazzinato nel DB.
     * @param ERegistrato $utente, utente del quale si richiedono le preferenze.
     * @return false|string, se l'utente è inserito nella newsletter vengono ritornati i metodi formattati in modo adeguato. Altrimenti ritorna false.
     */
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

    /**
     * Funzione che presa una stringa di preferenze formattata ricostruisce le preferenze dell'utente.
     * @param ERegistrato $utente, utente a cui appartengono le preferenze.
     * @param string $prefs, preferenze formatatte.
     */
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

    /**
     * @return array[]|mixed, funzione che serializza il contenuto della classe in formato JSON, necessario per rendere l'applicazione RESTFUL.
     */
    public function jsonSerialize() {
        return[
            'utentiConPreferenze' => $this->getListaUtenticonPreferenze(),
        ];
    }


}