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
    private $film;

    private array $proiezioni;

    public function __construct(){
        $this->proiezioni = array();
    }

//-------------- SETTER ----------------------
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
     * @return array insieme delle proiezioni del film
     */
    public function getProiezioni(): array {
        return $this->proiezioni;
    }

    public function getFilm() {
        return $this->film??null;
    }

    public function getDataInizio() {
        if (sizeof($this->proiezioni) > 0) {
            return $this->proiezioni[0]->getDataProiezione();
        }

        return null;
    }

    public function getDataFine() {
        if (sizeof($this->proiezioni) > 0) {
            return end($this->proiezioni)->getDataProiezione();
        }

        return null;
    }

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

        return false;
    }

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

    public function jsonSerialize ()
    {
        return
            [
                'proiezioni' => $this->getProiezioni(),
                'film' => $this->getFilm()->jsonSerialize()
            ];
    }

}