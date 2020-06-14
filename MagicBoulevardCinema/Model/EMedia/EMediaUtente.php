<?php


/**
 * Nella classe MediaLocandina sono presenti tutti i metodi e gli attributi necessari alla creazione e gestione di una immagine del profilo di un utente.
 * Class EMediaUtente
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EMediaUtente extends EMedia
{
    /**
     * Utente al quale appartiene l'immagine del profilo.
     * @var EUtente
     */
    private EUtente $utente;

    /**
     * EMediaUtente constructor.
     * @param string $fileName, nome del file.
     * @param string $mimeType, mimeType dle file.
     * @param DateTime $date, data di caricamento del file.
     * @param $immagine, contenuto del file.
     * @param EUtente $utente, utente al quale appartiene l'immagine del profilo.
     */
    public function __construct(string $fileName, string $mimeType, DateTime $date, $immagine, EUtente $utente) {
        parent::__construct($fileName, $mimeType, $date, $immagine);

        $this->setUtente($utente);
    }

    /**
     * @return EUtente, utente al quale appartiene l'immagine del profilo.
     */
    public function getUtente(): EUtente {
        return $this->utente;
    }

    /**
     * @param EUtente $utente, utente al quale appartiene l'immagine del profilo.
     */
    public function setUtente(EUtente $utente): void {
        $this->utente = $utente;
    }

    /**
     * @return array|mixed, funzione che serializza il contenuto della classe in formato JSON, necessario per rendere l'applicazione RESTFUL.
     */
    public function jsonSerialize() {
        $temp           = parent::jsonSerialize();
        $temp["utente"] = $this->utente->getId();

        return $temp;
    }
}