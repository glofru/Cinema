<?php
require_once ('ERegistrato.php');
//require once ('film.php')
/**Nella classe Giudizio sono presenti tutti i metodi e attributi necessari ad esprimere un giudizio da parte
 * dell'utente registrato
 * I suoi attributi sono i seguenti:
 * -commento: stringa che esprime un giudizio su un film
 * -punteggio: valore intero che espime un giudizio da 0 a 10 riguardante un film
 * Class EGiudizio
 */
class EGiudizio
{
    private string $commento;
    private int $punteggio;

    /**
     * EGiudizio constructor.
     * @param string $commento
     * @param int $punteggio
     */
    public function __construct(string $commento, int $punteggio)
    {
        $this->commento = $commento;
        $this->punteggio = $punteggio;
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
    public function getPunteggio(): int
    {
        return $this->punteggio;
    }

    /**
     * @param int $punteggio
     */
    public function setPunteggio(int $punteggio): void
    {
        $this->punteggio = $punteggio;
    }


}