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
    public function __construct(string $email, string $password)
    {
        parent::__construct("", "", "", $email, $password, 0);
    }

    public function compra() {
        echo "Compra non registrato";
    }

}