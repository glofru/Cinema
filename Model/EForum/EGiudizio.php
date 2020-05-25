<?php

/**Nella classe Giudizio sono presenti tutti i metodi e attributi necessari ad esprimere un giudizio da parte
 * dell'utente registrato
 * I suoi attributi sono i seguenti:
 * -commento: stringa che esprime un giudizio su un film
 * -punteggio: valore intero che espime un giudizio da 0 a 10 riguardante un film
 * Class EGiudizio
 */
class EGiudizio implements JsonSerializable
{
    private string $commento;
    private float $punteggio;
    private EFilm $film;
    private ERegistrato $utente;
    private string $title;

    /**
     * EGiudizio constructor.
     * @param string $commento
     * @param int $punteggio
     */
    public function __construct(string $commento, float $punteggio, EFilm $film, ERegistrato $utente, string $title)
    {
        $this->setCommento($commento);
        $this->setPunteggio($punteggio);
        $this->setFilm($film);
        $this->setUtente($utente);
        $this->setTitle($title);
    }

    /**
     * @return EFilm
     */
    public function getFilm(): EFilm
    {
        return $this->film;
    }

    /**
     * @param EFilm $film
     */
    public function setFilm(EFilm $film): void
    {
        $this->film = $film;
    }

    /**
     * @return string
     */
    public function getCommento(): string
    {
        return $this->commento;
    }

    /**
     * @param string $commento
     */
    public function setCommento(string $commento): void
    {
        $this->commento = $commento;
    }

    /**
     * @return int
     */
    public function getPunteggio(): float
    {
        return $this->punteggio;
    }

    /**
     * @param int $punteggio
     */
    public function setPunteggio(float $punteggio): void
    {
        $this->punteggio = $punteggio;
    }

    public function setUtente(ERegistrato $utente){
        $this->utente = $utente;
    }

    public function getUtente(): ERegistrato {
        return $this->utente;
    }

    public function setTitle(string $title) {
        $this->title = $title;
    }

    public function getTitle(): string {
        return $this->title;
    }


    public function jsonSerialize()
    {
        return [
            'film' => $this->getFilm(),
            'commento' => $this->getCommento(),
            'punteggio' => $this->getPunteggio(),
            'utente' => $this->getUtente()
        ];
    }
}