<?php
/**
 * Nella classe Sala sono i presenti attributi e metodi per la creazione e gestione della programmazione di un film
 * I suoi attributi sono i seguenti:
 * - proiezioni: insieme delle proiezioni del film
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EProgrammazioneFilm implements JsonSerializable
{
    /**
     * Insieme delle proiezioni del film
     * @AttributeType array
     */
    private array $proiezioni;

    private EFilm $film;


    public function __construct(){
        $this->proiezioni = array();
    }

//-------------- SETTER ----------------------
    public function addProiezione(EProiezione $proiezione){
        array_push($this->proiezioni, $proiezione);
        if($this->film === null) {
            $this->film = $proiezione->getFilm();
        }
    }

//----------------- GETTER --------------------
    /**
     * @return array insieme delle proiezioni del film
     */
    public function getProiezioni(): array {
        return $this->proiezioni;
    }

    public function getFilm(): EFilm {
        return $this->film;
    }

//------------- ALTRI METODI ----------------
    /**
     * Aggiunge una proiezione all'insieme
     * @param EProiezione $proiezione proiezione da aggiungere all'insieme
     */
    public function addProiezione(EProiezione $proiezione){
        array_push($this->proiezioni, $proiezione);
    }
    /**
     * Rimuove una proiezione dall'insieme
     * @param EProiezione $proiezione proiezione da rimuovere dall'insieme
     * @return bool valore che indica il successo dell'operazione
     */
    public function rimuoviProiezione(EProiezione $proiezione): bool{
        $result = array_search($proiezione,$this->getProiezioni());
        if($result !== ""){
            unset($this->getProiezioni()[$result]);
            return true;
        }
        else{
            return false;
        }
    }

    public function getDateProiezioni(): string {
        $dates = [];
        foreach($this->proiezioni as $pro) {
            array_push($dates, $pro->getDataproieizone());
        }
        usort($dates, "date_sort");
        $sun = "DOM:";
        $mon = "LUN:";
        $tue = "MAR:";
        $wed = "MER:";
        $thu = "GIO:";
        $fri = "VEN:";
        $sat = "SAB:";
        $days = [];
        array_push($days, $mon, $tue, $wed, $thu, $fri, $sat, $sun);
        foreach($dates as $d) {
            switch($d->format("D")) {
                case "Sun": $days[6] .= " " . $d->format("H:i"); break;
                case "Mon": $days[0] .= " " . $d->format("H:i"); break;
                case "Tue": $days[1] .= " " . $d->format("H:i"); break;
                case "Wed": $days[2] .= " " . $d->format("H:i"); break;
                case "Thu": $days[3] .= " " . $d->format("H:i"); break;
                case "Fri": $days[4] .= " " . $d->format("H:i"); break;
                case "Sat": $days[5] .= " " . $d->format("H:i"); break;
            }
        }
        $result = "";
        foreach($days as $d){
            if(strlen($d) > 4) {
                $result .= $d . "<br>";
            }
        }
        substr($result, 0, -1);
        return $result;
    }

    public function jsonSerialize ()
    {
        return
            [
                'proiezioni' => $this->getProiezioni(),
                'film' => $this->getFilm()->jsonSerialize()
            ];
    }

}