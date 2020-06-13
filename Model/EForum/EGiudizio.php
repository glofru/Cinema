<?php

/**Nella classe Giudizio sono presenti tutti i metodi e attributi necessari a permettere ad un utente registrato di esprimere un giudizio.
 * Class EGiudizio
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EGiudizio implements JsonSerializable
{
    /**
     * @var string, contenuto del giudizio espresso.
     */
    private string $commento;

    /**
     * @var float, punteggio assegnato al film da parte dell'utente.
     */
    private float $punteggio;

    /**
     * @var EFilm, film sul quale è stato espresso il giudizio.
     */
    private EFilm $film;

    /**
     * @var EUtente, utente che ha espresso il commento.
     */
    private EUtente $utente;

    /**
     * @var string, titolo del giudizio.
     */
    private string $title;

    /**
     * @var DateTime, data di pubblicazione del giudizio.
     */
    private DateTime $dataPubblicazione;

    /**
     * EGiudizio constructor.
     * @param string $commento, contentuo del giudizio.
     * @param float $punteggio, punteggio assegnato.
     * @param EFilm $film, film sul quale è stato espresso il giudizio.
     * @param EUtente $utente, utente che ha espresso il giudizio.
     * @param string $title, titolo del giudizio.
     * @param DateTime $dataPubblicazione, data di pubblicazione del giudizio.
     */
    public function __construct(string $commento, float $punteggio, EFilm $film, EUtente $utente, string $title, DateTime $dataPubblicazione)
    {
        $this->setCommento($commento);
        $this->setPunteggio($punteggio);
        $this->setFilm($film);
        $this->setUtente($utente);
        $this->setTitle($title);
        $this->setDataPubblicazione($dataPubblicazione);
    }

    /**
     * @return EFilm, film sul quale è stato espresso il giudizio.
     */
    public function getFilm(): EFilm
    {
        return $this->film;
    }

    /**
     * @param EFilm $film, film sul quale è stato espresso il giudizio.
     */
    public function setFilm(EFilm $film): void
    {
        $this->film = $film;
    }

    /**
     * @return string, contenuto del giudizio espresso.
     */
    public function getCommento(): string
    {
        return $this->commento;
    }

    /**
     * @param string $commento, contenuto del giudizio espresso.
     */
    public function setCommento(string $commento): void
    {
        $this->commento = EInputChecker::getInstance()->comment($commento);
    }

    /**
     * @return float, punteggio assegnato al film.
     */
    public function getPunteggio(): float
    {
        return $this->punteggio;
    }

    /**
     * @param float $punteggio, punteggio assegnato al film.
     */
    public function setPunteggio(float $punteggio): void
    {
        $this->punteggio = $punteggio;
    }

    /**
     * @param EUtente $utente, utente che ha espresso il giudizio.
     */
    public function setUtente(EUtente $utente){
        $this->utente = $utente;
    }

    /**
     * @return EUtente, utente che ha espresso il giudizio.
     */
    public function getUtente(): EUtente {
        return $this->utente;
    }

    /**
     * @param string $title, titolo del giudizio.
     */
    public function setTitle(string $title) {
        $this->title = EInputChecker::getInstance()->title($title);
    }

    /**
     * @return string, titolo del giudizio.
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @param DateTime $dataPubblicazione, data di pubblicazione del giudizio.
     */
    public function setDataPubblicazione(DateTime $dataPubblicazione) {
        $this->dataPubblicazione = $dataPubblicazione;
    }

    /**
     * @return DateTime, data di pubblicazione del giudizio.
     */
    public function getDataPubblicazione(): DateTime {
        return $this->dataPubblicazione;
    }

    /**
     * @return string, data di pubblicazione nel formato idoneo ad essere salvato nel DB.
     */
    public function getDataPubblicazioneDB(): string {
        return $this->dataPubblicazione->format('Y-m-d');
    }

    /**
     * @return string, data di pubblicazione nel formato giorno-mese-anno.
     */
    public function getDataPubblicazioneString(): string {
        return $this->dataPubblicazione->format('d-m-Y');
    }

    /**
     * Funzione che dato un insieme di giudizi restituisce la media dei voti raccolta dal film.
     * @param array $giudizi, insieme dei giudizi di un film
     * @return float|int, media dei voti ottenuti.
     */
    public static function getMedia(array $giudizi) {
        $result = 0;

        foreach ($giudizi as $g) {
            $result += $g->getPunteggio();
        }

        return $result == 0 ? $result : $result/sizeof($giudizi);
    }

    public static function sortByDatesGiudizi(EGiudizio $g1, EGiudizio $g2) {
        return $g1->getDataPubblicazione() < $g2->getDataPubblicazione();
    }

    /**
     * @return array|mixed, funzione che serializza il contenuto della classe in formato JSON, necessario per rendere l'applicazione RESTFULL.
     */
    public function jsonSerialize()
    {
        return [
            'film' => $this->getFilm(),
            'titolo' => $this->getTitle(),
            'commento' => $this->getCommento(),
            'punteggio' => $this->getPunteggio(),
            'dataPubblicazione' => $this->getDataPubblicazione(),
            'utente' => $this->getUtente()
        ];
    }
}