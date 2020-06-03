<?php


/**
 * Class EMail
 */
class EMail
{
    /**
     * @var string
     */
    private string $to;
    /**
     * @var string
     */
    private string $name;
    /**
     * @var string
     */
    private string $subject;
    /**
     * @var string
     */
    private string $body;

    /**
     * EMail constructor.
     * @param string $to
     * @param string $name
     * @param string $subject
     * @param string $body
     */
    public function __construct(string $to, string $name, string $subject, string $body)
    {
        $this->setTo($to);
        $this->setName($name);
        $this->setSubject($subject);
        $this->setBody($body);
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo(string $to): void
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }


}