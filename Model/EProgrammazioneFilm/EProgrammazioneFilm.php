<?php
/**
 * Nella classe Sala sono i presenti attributi e metodi per la creazione e gestione della programmazione di un film, contenente un insieme di proiezioni di un particolare film.
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EProgrammazioneFilm implements JsonSerializable
{
    /**
     * Film di cui si raccolgono le proiezioni.
     * @var EFilm
     */
    private EFilm $film;

    /**
     * Insieme delle proieizoni.
     * @var array
     */
    private array $proiezioni;

    /**
     * EProgrammazioneFilm constructor.
     */
    public function __construct(){
        $this->proiezioni = array();
    }

//-------------- SETTER ----------------------

    /**
     * @param EProiezione $proiezione, proiezione che si vuole inserire nell'insieme.
     */
    public function addProiezione(EProiezione $proiezione){
        array_push($this->proiezioni, $proiezione);

        usort($this->proiezioni, function ($a, $b) {
            return $a->getDataProiezione > $b->getDataProiezione();
        });

        if($this->film === null) {
            $this->film = $proiezione->getFilm();
        }
    }

//----------------- GETTER --------------------
    /**
     * @return array, insieme delle proiezioni del film.
     */
    public function getProiezioni(): array {
        return $this->proiezioni;
    }

    /**
     * @return EFilm|null, ritorna l'oggetto EFilm se settato altirmenti null.
     */
    public function getFilm() {
        return $this->film??null;
    }

    /**
     * @return DateTime|null, ritorna la data di inzio della prima proiezione, se non settata torna null.
     */
    public function getDataInizio() {
        if (sizeof($this->proiezioni) > 0) {
            return $this->proiezioni[0]->getDataProiezione();
        }

        return null;
    }

    /**
     * @return DateTime|null, ritorna la data dell'ultima proiezione nell'insieme, se non settata torna null.
     */
    public function getDataFine() {
        if (sizeof($this->proiezioni) > 0) {
            return end($this->proiezioni)->getDataProiezione();
        }

        return null;
    }

    /**
     * @return array, insieme degli orari nelle quali avvengono le proiezioni.
     */
    public function getFasceOrarie(): array {
        $fasceOrarie = [];

        foreach ($this->proiezioni as $pro) {
            $ora = $pro->getDataProiezione()->format("H:i");
            if (!in_array($ora, $fasceOrarie)) {
                array_push($fasceOrarie, $ora);
            }
        }

        usort($fasceOrarie, function ($a, $b) {
            $a = explode(":", $a);
            $b = explode(":", $b);

            if ($a[0] === $b[0]) {
                return intval($a[1]) > intval($b[1]);
            }

            return intval($a[0]) > intval($b[0]);
        });

        return $fasceOrarie;
    }
//------------- ALTRI METODI ----------------
    /**
     * Funzione che imuove una proiezione dall'insieme.
     * @param EProiezione $proiezione proiezione da rimuovere dall'insieme.
     * @return bool valore che indica il successo dell'operazione.
     */
    public function rimuoviProiezione(EProiezione $proiezione): bool{
        $result = array_search($proiezione,$this->getProiezioni());
        if($result !== ""){
            unset($this->getProiezioni()[$result]);
            return true;
        }

        return false;
    }

    /**
     * Funzione che, preso l'insieme delle proiezioni, restituisce una stringa contente per ogni giorno della settimana gli orari nei quali avverranno le proieizoni.
     * @return string, giorni ed orari delle proiezioni.
     */
    public function getDateProiezioni(): string {
        $dates = [];
        foreach($this->proiezioni as $pro) {
            array_push($dates, $pro->getDataProieizone());
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

    /**
     * Funzione che controlla se una programmazioneFilm contiene proiezioni che sono già state proiettate. Ritornando un array con le proiezioni che ancota non sono avvenute.
     * @param EProgrammazioneFilm $proiezionifilm, insieme di proiezioni che si vuole controllare.
     * @return EProgrammazioneFilm, insieme di proieizoni non ancota avvenute.
     */
    public static function amIStillGood(EProgrammazioneFilm $proiezionifilm): EProgrammazioneFilm {
        $result = new EProgrammazioneFilm();
        $today = new DateTime('now');

        foreach($proiezionifilm->getProiezioni() as $pro) {
            if($pro->getDataproieizone() > $today) {
                $result->addProiezione($pro);
            } else if($pro->getDataproieizone() == $today){
                if(strtotime($today->format('H:i')) - strtotime($pro->getDataProiezione()->format('H:i')) > 0) {
                    $result->addProiezione($pro);
                }
            }
        }

        return $result;
    }

    /**
     * @return array|mixed, funzione che serializza il contenuto della classe in formato JSON, necessario per rendere l'applicazione RESTFULL.
     */
    public function jsonSerialize ()
    {
        return
            [
                'proiezioni' => $this->getProiezioni(),
                'film' => $this->getFilm()->jsonSerialize()
            ];
    }

}