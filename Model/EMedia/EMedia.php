<?php


/**
 * Nella classe Media sono presenti tutti i metodi e gli attributi necessari alla creazione e gestione delle immagini.
 * Class EMedia
 * @access public
 * @author Lofrumento - Di Santo - Susanna
 * @package Model
 */
class EMedia implements JsonSerializable
{
    /**
     * Id dell'immagine.
     * @var string
     */
    private int $id = 0;
    /**
     * Nome del file.
     * @var string
     */
    private string $fileName;
    /**
     * MimeType dell'immagine.
     * @var string
     */
    private string $mimeType;
    /**
     * data di caricamento dell'immagine.
     * @var DateTime
     */
    private DateTime $date;

    /**
     * contenuto dell'immagine.
     * @var
     */
    private $immagine;

    /**
     * EMedia constructor.
     * @param string $fileName, nome dle file.
     * @param string $mimeType, mimeType del file.
     * @param DateTime $date, data di caricamento del file.
     * @param $immagine, contenuto del file.
     */
    public function __construct(string $fileName, string $mimeType, DateTime $date, $immagine)
    {
        $this->setFileName($fileName);
        $this->setMimeType($mimeType);
        $this->setDate($date);
        $this->setImmagine($immagine);
    }


    /**
     * @return int, id dell'immagine.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id, id dell'immagine.
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string, nome del file.
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName, nome del file.
     */
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    /**
     * @return string, mimeType del file.
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType, mimeType del file.
     */
    public function setMimeType(string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return DateTime, data di caricamento del file.
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date, data di caricamento dle file.
     */
    public function setDate(DateTime $date): void
    {
        if ($date == null)
        {
            $date = time();
        }
        else
        {
            $this->date = $date;
        }
    }

    /**
     * @return string, data di caricamento nel formato giorno-mese-anno.
     */
    public function getDateString(): string
    {
        return $this->getDate()->format('d-m-Y');
    }

    /**
     * @return string, data di caricamento nel formato adatto ad essere caricato sul DB.
     */
    public function getDateStringSQL(): string
    {
        return $this->getDate()->format('Y-m-d');
    }

    /**
     * @return mixed, contenuto del file immagine.
     */
    public function getImmagine()
    {
        return $this->immagine;
    }

    /**
     * Funzione che restituisce il path dell'immagine di default se non è stata caricata alcuna immagine. Altrimenti restituisce l'immagine con un header adatto ad essere decodificata in fase di visualizzazione.
     * @return string, immagine.
     */
    public function getImmagineHTML(): string{
        $mime = explode("/",$this->getMimeType());
        return ($this->getImmagine() === '../../Smarty/img/user.png') ? $this->getImmagine() : "data:image/". $mime[1] . ";base64," . $this->getImmagine();
    }

    /**
     * @param mixed $immagine, contenuto del file immagine.
     */
    public function setImmagine($immagine): void
    {
        $this->immagine = $immagine;
    }

    /**
     * @return array|mixed, funzione che serializza il contenuto della classe in formato JSON, necessario per rendere l'applicazione RESTFULL.
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'immagine' => $this->getImmagineHTML(),
            'fileName' => $this->getFileName(),
            'mimeType' => $this->getMimeType(),
            'date' => $this->getDate()->format("Y-m-d h:i:s")
        ];
    }
}