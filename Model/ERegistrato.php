<?php
require_once ('EGiudizio.php');

/**Nella clesse Utente sono presenti tutti i metodi e attributi necessari a definire il profilo di un utente
 * registrato
 * Class ERegistrato
 */
class ERegistrato extends EUtente
{
   private array $listagiudizi=[];

    /**
     * ERegistrato constructor.
     */
    public function __construct()
    {

    }


    /**
     * @return array
     */
    public function getListagiudizi(): array
    {
        return $this->listagiudizi;
    }

    /**
     * @param array $listagiudizi
     */
    public function setListagiudizi(array $listagiudizi): void
    {
        $this->listagiudizi = $listagiudizi;
    }

}