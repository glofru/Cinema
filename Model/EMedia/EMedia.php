<?php


/**
 * Class EMedia
 */
class EMedia implements JsonSerializable
{
    /**
     * @var string
     */
    private int $id = 0;
    /**
     * @var string
     */
    private string $fileName;
    /**
     * @var string
     */
    private string $mimeType;
    /**
     * @var DateTime
     */
    private DateTime $date;

    /**
     * @var
     */
    private $immagine;

    /**
     * EMedia constructor.
     * @param string $id
     * @param string $fileName
     * @param string $mimeType
     * @param DateTime $date
     * @param $immagine
     */
    public function __construct(string $fileName, string $mimeType, DateTime $date, $immagine)
    {
        $this->setFileName($fileName);
        $this->setMimeType($mimeType);
        $this->setDate($date);
        $this->setImmagine($immagine);
    }


    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType(string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
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

    public function getDateString(): string
    {
        return $this->getDate()->format('d-m-Y');
    }

    public function getDateStringSQL(): string
    {
        return $this->getDate()->format('Y-m-d');
    }

    /**
     * @return mixed
     */
    public function getImmagine()
    {
        return $this->immagine;
    }

    public function getImmagineHTML(): string{
        $mime = explode("/",$this->getMimeType());
        return ($this->getImmagine() === '../../Smarty/img/user.png') ? $this->getImmagine() : "data:image/". $mime[1] . ";base64," . $this->getImmagine();
    }

    /**
     * @param mixed $immagine
     */
    public function setImmagine($immagine): void
    {
        $this->immagine = $immagine;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'fileName' => $this->getFileName(),
            'mimeType' => $this->getMimeType(),
            'date' => $this->getDate()->format("Y-m-d h:i:s")
        ];
    }
}