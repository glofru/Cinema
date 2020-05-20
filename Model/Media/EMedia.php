<?php


/**
 * Class EMedia
 */
class EMedia implements JsonSerializable
{
    /**
     * @var string
     */
    private string $id;
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
     * EMedia constructor.
     * @param string $id
     * @param string $fileName
     * @param string $mimeType
     * @param DateTime $date
     */
    public function __construct(string $id, string $fileName, string $mimeType, DateTime $date)
    {
        $this->setId($id);
        $this->setFileName($fileName);
        $this->setMimeType($mimeType);
        $this->setDate($date);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
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