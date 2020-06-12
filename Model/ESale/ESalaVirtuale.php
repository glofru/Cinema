<?php
/**
 * Nella classe Sala sono i presenti attributi e metodi per creare una sala per il cinema
 * I suoi attributi sono i seguenti:
 * - numero: valore numerico che identifica la sala;
 * - posti: array di posti contenente tutti i possibili posti a sedere presenti in sala;
 * - numeroposti: valore numerico che identifica la capienza della sala;
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

    public function __construct(int $numeroSala, int $nFile, int $nPostiFila, bool $disponibile) {
        parent::__construct($numeroSala, $nFile, $nPostiFila, $disponibile);
        $this->init($nFile, $nPostiFila);
    }

    public static function fromSalaFisica(ESalaFisica $salaFisica) {
        return new ESalaVirtuale($salaFisica->getNumeroSala(), $salaFisica->getNFile(), $salaFisica->getNPostiFila(), $salaFisica->isDisponibile());
    }

    /**
     * @param $nFile
     * @param $nPostiFila
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
     * @return array posti a sedere nella sala
     */
    public function getPosti(): array {
        return $this->posti;
    }

//------------- ALTRI METODI ----------------

    /**
     * @return array|mixed
     */
    public function jsonSerialize () {
        return
            [
                'numero'   => $this->getNumeroSala(),
                'posti' => $this->getPosti(),
                'nFile' => $this->getNFile(),
                'nPostiFila' => $this->getNPostiFila()
            ];
    }

    /**
     * Controlla se un posto è presente realmente nella sala gestita
     * @param EPosto $posto posto che si vuole controllare
     * @return bool indice del posto nell'array dei posti in sala
     */
    public function exists(EPosto $posto): bool {
        return array_key_exists($posto->getFila(), $this->posti) && array_key_exists($posto->getNumeroPosto(), $this->posti[$posto->getFila()]);
    }

    public function getIfExists(EPosto $posto) {
        if ($this->exists($posto)) {
            return $this->posti[$posto->getFila()][$posto->getNumeroPosto()];
        }

        return null;
    }

    /**
     * Controlla se un posto è libero in sala
     * @param EPosto $posto posto che si vuole controllare
     * @return bool risultato del controllo
     * @throws Exception
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
     * Controlla se un posto è occupato o meno in sala
     * @param EPosto $posto posto che si vuole controllare
     * @return bool risultato del controllo
     */
    public function occupaPosto(EPosto $posto): bool
    {
        if (!$this->isPostoOccupato($posto)) {
            $this->posti[$posto->getFila()][$posto->getNumeroPosto()]->setIsOccupato(true);
            return true;
        }

        return false;
    }
    /**
     * Controlla se un posto è occupato in sala
     * @param EPosto $posto posto che si vuole controllare
     * @return bool risultato booleano del controllo
     */
    public function liberaPosto(EPosto $posto): bool
    {
        if ($this->isPostoOccupato($posto)) {
            $this->posti[$posto->getFila()][$posto->getNumeroPosto()]->setIsOccupato(false);
            return true;
        }

        return false;
    }

    public function getNumeroPosti(): int {
        return sizeof($this->getPosti());
    }
    /**
     * Conta il numero dei posti liberi in sala
     * @return int numero dei posti liberi in sala
     */
    public function getNumeroPostiLiberi(): int
    {
        $count = 0;
        foreach ($this->getPosti() as $elem){
            if($elem->isOccupato() === false){
                $count += 1;
            }
        }
        return $count;
    }
    /**
     * Conta il numero dei posti occupati in sala
     * @return int numero dei posti occupati in sala
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