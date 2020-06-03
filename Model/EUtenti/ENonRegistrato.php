<?php


/**
 * Class ENonRegistrato
 */
class ENonRegistrato extends EUtente
{
    /**
     * ENonRegistrato constructor.
     * @param string $email
     * @throws Exception
     */
    public function __construct(string $email)
    {
        $this->setEmail($email);
    }

    public function compra() {
        echo "Compra non registrato";
    }

}