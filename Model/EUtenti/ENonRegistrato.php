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
        parent::__construct(null, null, null, $email, null, null);
    }

    public function compra() {
        echo "Compra non registrato";
    }

}