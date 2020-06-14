<?php


/**
 * La classe FPersistentManager si presenta come interfaccia fra le classi del package Foundation e le classi Controller che la interrogano per effettuare le operazioni CRUD sul database.
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Foundation
 */
class FPersistentManager
{
    /**
     * @var FPersistentManager
     * Istanza del PersistenManager, gestito come Singleton.
     */
    private static $instance;

    /**
     * FPersistentManager constructor.
     */
    private function __construct() {}

    /**
     * @return FPersistentManager
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new FPersistentManager();
        }

        return self::$instance;
    }

    /**
     * Funzione che provvede a sostituire il nome delle classi Entity che richiamano il PM con le rispettive classi in Foundation.
     * @param string $class , classe entity che sta chiamando il PersistentManager.
     * @return string
     */
    private function getClass(string $class){
        if($class === "EAdmin" || $class === "ERegistrato" || $class === "ENonRegistrato"){
            return "FUtente";
        } elseif($class === "EMediaLocandina" || $class === "EMediaUtente") {
            return "FMedia";
        } elseif($class === "ESalaFisica") {
            return "FSala";
        } elseif($class === "EProgrammazione" || $class === "EElencoProgrammazioni") {
            return "FProiezione";
        }

        $class[0] = "F";
        return $class;
    }

    /**
     * Funzione che permette di salvare nel DB una istanza di una classe Entity.
     * @param $istanza, oggetto che si vuole salvare.
     */
    public function save($istanza) {
        $class = self::getClass(get_class($istanza));
        $class::save($istanza);
    }

    /**
     * Funzione che permette di salvare nel DB le preferenze di Newsletter di un utente.
     * @param $utente, utente da aggiungere alla Newsletter.
     * @param $preferenze, preferenze dell'utente da aggiungere.
     */
    public function saveNS($utente, $preferenze) {
        FNewsLetter::save($utente, $preferenze);
    }

    /**
     * Funzione che prende in input la programmazione di un particolare film e salva nel DB le proiezioni associate. Ritorna l'esito dell'operazione.
     * @param EProgrammazioneFilm $programmazioneFilm, insieme delle proiezioni di un film.
     * @return bool, esito dell'operazione.
     */
    public function saveProgrammazione(EProgrammazioneFilm $programmazioneFilm): bool {
        foreach ($programmazioneFilm->getProiezioni() as $p) {
            if(FProiezione::save($p) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Funzione che permette dato un valore una colonna ed una classe di repererire dal DB un oggetto. Può tornare un array di oggetti oppure null.
     * @param $value, valore necessario ad indentificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @param $class, classe entity che richiama il PM.
     * @return mixed, array di oggetti o null.
     */
    public function load($value, $row, $class) {
        $class = self::getClass($class);

        return $class::load($value, $row);
    }

    /**
     * Funzione che permette di reperire dalla persistenza tutti gli utenti bannati dagli amministratori. Ritorna un array di utenti oppure null in caso di errore.
     * @return array|null, array di oggetti o null.
     */
    public function loadbannati() {
        return FUtente::loadBannati();
    }

    /**
     * Funzione che permette di reperire oggetti dal DB fornendo un valore (value) ed una colonna (row) nella quale cercare valori simili a value, usato per la ricerca film ad esempio.
     * @param $value, valore necessario ad indentificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @param $class, classe entity che sta chiamando il PM.
     * @return mixed, array di oggetti.
     */
    public function loadLike($value, $row, $class) {
        $value = str_replace("'", "\'", $value);
        $class = self::getClass($class);

        return $class::loadLike($value, $row);
    }

    /**
     * Funzione che permette di caricare oggetti dal database se questi sono entità deboli. Necessitano, quindi, di due valori e due colonne. Viene restituito un oggetto o null.
     * @param $value, primo valore necessario ad indentificare l'oggetto.
     * @param $row, prima colonna nella quale cercare il valore.
     * @param $value2, primo valore necessario ad indentificare l'oggetto.
     * @param $row2, prima colonna nella quale cercare il valore.
     * @param $class, classe entity che sta chiamando il PM.
     * @return mixed, oggetto o null.
     */
    public function loadDebole($value, $row, $value2, $row2, $class) {
        $class = self::getClass($class);

        return $class::loadDoppio($value, $row, $value2, $row2);
    }

    /**
     * Funzione che permette di effettuare una ricerca nel DB attraverso un intervallo di valori. Usato ad esempio nella ricerca film per ottenere quali siano stati rilasciati in un deterinato intervallo di tempo.
     * @param $inizio, data di inizio.
     * @param $fine, data di fine.
     * @param $class, classe entity che sta chiamndo il PM.
     * @return array, array di oggetti.
     */
    public function loadBetween($inizio, $fine, $class) {
        $class = self::getClass($class);

        return $class::loadBetween($inizio, $fine);
    }

    /**
     * Funzione che permette di reperire tutti gli oggetti presenti sul DB di una particolare classe passata come input. Torna un array o una istanza di EElencoProgrammazioni.
     * @param $class, classe entity che sta chiamndo il PM.
     * @return mixed, array di oggetti o una istanza di EElencoProgrammazioni.
     */
    public function loadAll($class) {
        $class = self::getClass($class);

        return $class::loadAll();
    }

    /**
     * Funzione che ritorna il numero di sale fisiche attualemnte presenti nel DB.
     * @return int, numero di SaleFisiche.
     */
    public function loadAllSF(): int {
        return FSala::nLoadAll();
    }

    /**
     * Funzione che permette di eliminare un oggetto dal DB dato un valore ed una colonna.
     * @param $value, valore necessario ad indentificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @param $class, classe entity che sta chiamando il PM.
     * @return bool, esito dell'operazione.
     */
    public function delete($value, $row, $class): bool {
        $class = self::getClass($class);

        return $class::delete($value, $row);
    }

    /**
     * Funzione che permette di eliminare un oggetto dal DB se l'entità è debole. Quindi gli vengono forniti due valori e due colonne. Ritorna l'esito dell'operazione.
     * @param $value, primo valore necessario ad indentificare l'oggetto.
     * @param $row, prima colonna nella quale cercare il valore.
     * @param $value2, primo valore necessario ad indentificare l'oggetto.
     * @param $row2, prima colonna nella quale cercare il valore.
     * @param $class, classe entity che sta chiamndo il PM.
     * @return bool, esito dell'operazione.
     */
    public function deleteDebole($value, $row, $value2, $row2, $class): bool {
        $class = self::getClass($class);

        return $class::delete($value, $row, $value2, $row2);
    }

    /**
     * Funzione che permette di aggiornare un oggetto salvato nel DB. Ritorna l'esito dell'operazione.
     * @param $value, valore necessario ad indentificare l'oggetto.
     * @param $row, colonna nella quale cercare il valore.
     * @param $newValue
     * @param $newRow
     * @param $class, classe entity che sta chiamndo il PM.
     * @return bool, esito dell'operazione.
     */
    public function update($value, $row, $newValue, $newRow, $class): bool {
        $class = self::getClass($class);

        return $class::update($value, $row, $newValue, $newRow);
    }

    /**
     * Funzione che permette di aggiornare il DB se l'entità è debole. Ritorna l'esito dell'operazione.
     * @param $value, primo valore necessario ad indentificare l'oggetto.
     * @param $row, prima colonna nella quale cercare il valore.
     * @param $value2, primo valore necessario ad indentificare l'oggetto.
     * @param $row2, prima colonna nella quale cercare il valore.
     * @param $newValue, valore che si vuole inserire.
     * @param $newRow, colonna nella quale inserire il nuovo valore.
     * @param $class, classe entity che sta chiamndo il PM.
     * @return bool, esito dell'operazione.
     */
    public function updateDebole($value, $row, $value2, $row2, $newValue, $newRow, $class): bool {
        $class = $this::getClass($class);

        return $class::update($value, $row, $value2, $row2, $newValue, $newRow);
    }

    /**
     * Funzione che permette, dato un insieme di biglietti, di prenotare i posti relativi ad ogni bilgietto. Ritorna l'esito dell'operazione.
     * @param array $biglietti, arry di biglietti da cui estrarre i posti da occupare.
     * @return bool|null, esito dell'opreazione.
     */
    public function occupaPosti(array $biglietti) {
        return FProiezione::occupaPosti($biglietti);
    }

    /**
     * Funzione che permette attraverso username o email, la password ed un valore (che identifica se è stato passato un username od una mail) di controllare se le credenziali appartengano ad un utente. Torna un Utente oppure null.
     * @param string $value, username o email dell'utente.
     * @param string $password, password dell'utente.
     * @param bool $isMail, se il valore passato è un username o una mail.
     * @return mixed|null
     */
    public function login(string $value, string $password, bool $isMail) {
        return FUtente::login($value, $password, $isMail);
    }

    /**
     * Funzione che permette, dato un utente, di registrarlo nel DB.
     * @param EUtente $utente , utente da registrare.
     * @throws Exception
     */
    public function signup(EUtente $utente) {
        FUtente::save($utente);
    }

    /**
     * Funzione che permette, dato un utente, di modificarne la password.
     * @param EUtente $utente , utente a cui aggiornare la password.
     * @throws Exception
     */
    public function updatePasswordUser(EUtente $utente) {
        FUtente::updatePwd($utente);
    }

    /**
     * Funzione che permette di caricare oggetti EFilm dal DB sulla base di alcuni filtri impostati dall'utente. Ritorna un array contente gli oggetti che rispettano i criteri.
     * @param $genere, genere del film.
     * @param float $votoInizio, voto minimo del film che si sta cercando.
     * @param float $votoFine, voto massimo del film che si sta cercando.
     * @param DateTime $annoInizio, anno minimo nel quale il film deve essere stato rilasciato.
     * @param DateTime $annoFine, anno massimo nel quale il film deve essere stato rilasciato.
     * @return array, array di EFilm.
     */
    public function loadFilmByFilter($genere, float $votoInizio, float $votoFine, DateTime $annoInizio, DateTime $annoFine) {
        return FFilm::loadByFilter($genere, $votoInizio, $votoFine, $annoInizio, $annoFine);
    }

    /**
     * Funzione che permette di individuare se un utente è iscritto o meno alla Newsletter.
     * @param EUtente $utente, utente da cercare.
     * @return bool, se l'utente è iscritto alla newsletter.
     */
    public function isASub(EUtente $utente): bool{
        return FNewsLetter::isASub($utente);
    }

    public function isSovrappostaProiezione(EProiezione $proiezione): bool {
        return FProiezione::isSovrapposto($proiezione);
    }

    public function exists(EUtente $utente, $isMail) {
        return FUtente::exists($utente, $isMail);
    }
}