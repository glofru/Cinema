<?php


/**
 * Class ENonRegistrato
 */
class ENonRegistrato extends EUtente
{
    /**
     * ENonRegistrato constructor.
     * @param string $email
     * @param string $password
     * @throws Exception
     */
    public function __construct(string $email, string $password)
    {
        parent::__construct("", "", "", $email, $password, false);
    }

    public function compra() {
        echo "Compra non registrato";
    }

}