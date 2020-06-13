<?php

/**
 * Nella classe Data sono presenti alcuni metodi necessari a reperire alcuni intervalli di date necessari a permetterci di gestire le programmazioni ed i film. Estende la classe DateTime.
 * Class EData
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EData extends DateTime
{
    /**
     * EData constructor.
     * @param string $time, data da usare per costruire l'oggetto.
     * @param DateTimeZone|null $timezone, timezone dell'area geografica.
     * @throws Exception
     */
    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
    }

    /**
     * Funzione che identifica la data odierna e fornisce una data futura.
     * @return array, array di stringhe con la data odierna ed una data futura.
     */
    public static function getDateProssime(): array {
        $result = [];

        $oggi = new DateTime('now');
        $oggi = $oggi->format('Y-m-d');
        $fine = "2100-01-01";

        array_push($result, $oggi, $fine);

        return $result;
    }

    /**
     * Funzione che restituisce la data del primo e dell'ultimo giorno (Lunedì e Domenica) della settimana corrente.
     * @return array, array di stringhe con data del primo giorno della settimana e ultimo giorno della settimana.
     */
    public static function getSettimana(): array {
        $result = [];

        $inizio = new DateTime('now');
        $giorno = $inizio->format('D');

        while($giorno != 'Mon') {
            $inizio->modify('-1 Day');
            $giorno = $inizio->format('D');
        }

        $inizio = $inizio->format('Y-m-d');
        $fine = DateTime::createfromFormat('Y-m-d', $inizio);
        $fine->modify('+ 6 Days');
        $fine = $fine->format('Y-m-d');

        array_push($result, $inizio, $fine);

        return $result;
    }

    /**
     * Funzione che restituisce la data del primo e dell'ultimo giorno (Lunedì e Domenica) della settimana prossima.
     * @return array, array di stringhe con data del primo giorno della settimana e ultimo giorno della settimana prossima.
     */
    public static function getSettimanaProssima(): array {
        $result = [];

        $inizio = new DateTime('now');

        for($i = 0; true; $i++) {
            $inizio->modify('+1 Day');
            $giorno = $inizio->format('D');
            if($giorno == 'Mon' && $i > 0) {
                break;
            }
        }

        $inizio = $inizio->format('Y-m-d');
        $fine = DateTime::createfromFormat('Y-m-d', $inizio);
        $fine->modify('+ 6 Days');
        $fine = $fine->format('Y-m-d');

        array_push($result, $inizio, $fine);

        return $result;
    }

    /**
     * Funzione che restituisce la data del primo e dell'ultimo giorno (Lunedì e Domenica) di un numero di settimane passate pari a n.
     * @param int $n, numero di settimane passate rispetto a quella attuale -> 1 - settimana scorsa. 2 - 2 settimane fà...
     * @return array, array di stringhe con data del primo giorno della settimana e ultimo giorno della settimana cercata.
     */
    public static function getSettimanaScorsa(int $n): array {
        $result = [];

        $inizio = new DateTime('now');

        $k = ($n * 6);
        if($n > 2) {$k += $n - 2;}

        for($i = 0; true; $i++) {
            $inizio->modify('-1 Day');
            $giorno = $inizio->format('D');
            if($giorno == 'Mon' && $i >= $k) {
                break;
            }
        }

        $inizio = $inizio->format('Y-m-d');
        $fine = DateTime::createfromFormat('Y-m-d',$inizio);
        $fine->modify('+ 6 Days');
        $fine = $fine->format('Y-m-d');

        array_push($result, $inizio, $fine);

        return $result;
    }

    /**
     * Funzione che ritorna il giorno corrispondente a due settimane prima dell'inizio del mese ed il primo giorno del mese meno 30 anni.
     * @return array, array di stringhe con data di due settimane prima dell'inizio del mese ed il primo giorno del mese meno 30 anni.
     */
    public static function getDatePassate():array {
        $oggi = new DateTime('first day of this month - 2 weeks');
        $oggi = $oggi->format('Y-m-d');

        $fine = new DateTime('first day of this month - 30 years');
        $fine = $fine->format('Y-m-d');

        $date = [];

        array_push($date, $oggi, $fine);

        return $date;
    }

    /**
     * Funzione che da un numero di minuti restituisce la forma analoga in ore:minuti.
     * @param $time, minuti.
     * @param string $format, formato dell'ouput.
     * @return string, risultato della trasformazione da minuti ad ore e minuti.
     */
    public static function hoursandmins($time, $format = '%02d:%02d') {
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }
}