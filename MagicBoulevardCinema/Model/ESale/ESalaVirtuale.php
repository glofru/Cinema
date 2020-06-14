<?php
/**
 * Nella classe SalaVirtuale sono i presenti attributi e metodi per creare e gestire una sala nella quale avviene una proiezione. Astrazione della reale sala fisica necessaria a gestire l'ideale molteplicità di una singola sala.
 * Class ESalaVirtuale
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class ESalaVirtuale extends ESalaFisica implements JsonSerializable
{
    /**
     * Insieme dei posti presenti in sala
     * @AttributeType array
     */
    private array $posti;

    /**
     * ESalaVirtuale constructor.
     * @param int $numeroSala, numero di sala.
     * @param int $nFile, numero di file presenti in sala.
     * @param int $nPostiFila, numero di posti per ogni fila della sala.
     * @param bool $disponibile, se la sala sia disponibile.
     */
    public function __construct(int $numeroSala, int $nFile, int $nPostiFila, bool $disponibile) {
        parent::__construct($numeroSala, $nFile, $nPostiFila, $disponibile);

        $this->init($nFile, $nPostiFila);
    }

    /**
     * Funzione che data una sala fisica ne crea la corrispettiva sala virtuale.
     * @param ESalaFisica $salaFisica, la sala che si vuole usare come riferimento.
     * @return ESalaVirtuale, una nuova sala virtuale basata sulla corrispettiva fisica.
     */
    public static function fromSalaFisica(ESalaFisica $salaFisica) {
        return new ESalaVirtuale($salaFisica->getNumeroSala(), $salaFisica->getNFile(), $salaFisica->getNPostiFila(), $salaFisica->isDisponibile());
    }

    /**
     * Funzione che crea i posti nella sala sulla base del numero di file e del numero di posti per fila.
     * @param $nFile, numero di file.
     * @param $nPostiFila, numero di posti per fila.
     */
    private function init($nFile, $nPostiFila) {
        $this->posti = array();

        $value = 65; //65 = A
        for ($i = 0; $i < $nFile; $i++) {
            $fila = chr($value+$i);
            $this->posti[$fila] = array();

            for ($j = 0; $j < $nPostiFila; $j++) {
                $numeroPosto = $j + 1;
                $this->posti[$fila][$numeroPosto] = new EPosto($fila, $numeroPosto);
            }
        }
    }

    /**
     * @return array, posti a sedere nella sala.
     */
    public function getPosti(): array {
        return $this->posti;
    }

    /**
     * @return array|mixed, funzione che serializza il contenuto della classe in formato JSON, necessario per rendere l'applicazione RESTFULL.
     */
    public function jsonSerialize () {
        return [
            'numero'     => $this->getNumeroSala(),
            'posti'      => $this->getPosti(),
            'nFile'      => $this->getNFile(),
            'nPostiFila' => $this->getNPostiFila()
        ];
    }

    /**
     * Funzione che controlla se un posto è presente realmente nella sala gestita.
     * @param EPosto $posto, posto che si vuole controllare.
     * @return bool, indice del posto nell'array dei posti in sala.
     */
    public function exists(EPosto $posto): bool {
        return array_key_exists($posto->getFila(), $this->posti) && array_key_exists($posto->getNumeroPosto(), $this->posti[$posto->getFila()]);
    }

    /**
     * Funzione che controlla se un posto esista nella sala.
     * @param EPosto $posto, posto che si vuole controllare.
     * @return mixed|null, esito del controllo.
     */
    public function getIfExists(EPosto $posto) {
        if ($this->exists($posto)) {
            return $this->posti[$posto->getFila()][$posto->getNumeroPosto()];
        }

        return null;
    }

    /**
     * Funzione che controlla se un posto è libero in sala.
     * @param EPosto, $posto posto che si vuole controllare.
     * @return bool, risultato del controllo.
     * @throws Exception, se il posto non esiste in sala.
     */
    public function isPostoOccupato(EPosto $posto): bool {
        $p = $this->getIfExists($posto);

        if ($p !== null) {
            return $p->isOccupato();
        } else {
            throw new Exception("Posto inesistente");
        }
    }

    /**
     * Funzione che controlla se un posto è occupato o meno in sala.
     * @param EPosto $posto, posto che si vuole controllare.
     * @return bool, risultato booleano del controllo.
     * @throws Exception
     */
    public function occupaPosto(EPosto $posto): bool {
        if (!$this->isPostoOccupato($posto)) {
            $this->posti[$posto->getFila()][$posto->getNumeroPosto()]->setIsOccupato(true);
            return true;
        }

        return false;
    }

    /**
     * Funzione che controlla se un posto è occupato in sala.
     * @param EPosto $posto , posto che si vuole controllare.
     * @return bool, risultato booleano del controllo.
     * @throws Exception
     */
    public function liberaPosto(EPosto $posto): bool {
        if ($this->isPostoOccupato($posto)) {
            $this->posti[$posto->getFila()][$posto->getNumeroPosto()]->setIsOccupato(false);
            return true;
        }

        return false;
    }

    /**
     * Funzione che ritorna il numero di posti nella sala.
     * @return int, numero di posti in sala.
     */
    public function getNumeroPosti(): int {
        return sizeof($this->getPosti());
    }

    /**
     * Funzione che conta il numero dei posti liberi in sala.
     * @return int, numero dei posti liberi in sala.
     */
    public function getNumeroPostiLiberi(): int {
        $count = 0;

        foreach ($this->getPosti() as $elem){
            if($elem->isOccupato() === false){
                $count += 1;
            }
        }

        return $count;
    }
    /**
     * Funzione che conta il numero dei posti occupati in sala.
     * @return int, numero dei posti occupati in sala.
     */
    public function postiOccupati(): int{
        return $this->getNumeroPosti() - $this->getNumeroPostiLiberi();
    }

    /**
     * @return string
     */
    public function __toString(){
        return "La sala " . $this->getNumeroSala() . "ha " . $this->getNumeroPosti() . " posti.";
    }
}