<?php


class FRegistrato
{
    private static string $className = "FRegistrato";
    private static string $tableName = "Registrato";
    private static string $valuesName = "(:idRegistrato,:nome,:cognome,:username,:email,:password,:isAdmin)";

    private bool $isAdmin;
    private int $idRegistrato;

    /**
     * @return int
     */
    public function getidRegistrato(): int
    {
        return $this->idRegistrato;
    }

    /**
     * @param int $idRegistrato
     */
    public function setidRegistrato(int $idRegistrato): void
    {
        $this->idRegistrato = $idRegistrato;
    }


    /**
     * @return bool
     */
    public function getisAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setisAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    public function __construct()
    {

    }

    public function associate(PDOStatement $sender, ERegistrato $registrato){
        $sender->bindValue(':idRegistrato', $this->getidRegistrato(), PDO::PARAM_INT);
        $sender->bindValue(':nome', $registrato->getNome(), PDO::PARAM_STR);
        $sender->bindValue(':cognome', $registrato->getCognome(), PDO::PARAM_STR);
        $sender->bindValue(':username', $registrato->getUsername(), PDO::PARAM_STR);
        $sender->bindValue(':email', $registrato->getEmail(), PDO::PARAM_STR);
        $sender->bindValue(':password', $registrato->getPassword(), PDO::PARAM_STR);
        $sender->bindValue(':isAdmin', $this->getisAdmin(), PDO::PARAM_BOOL);
    }


    public static function getClassName()
    {
        return self::$className;
    }

    public static function getTableName()
    {
        return self::$tableName;
    }

    public static function getValuesName()
    {
        return self::$valuesName;
    }

    public static function save(ERegistrato $registrato)
    {
        $db = FDatabase::getInstance();
        $db->saveToDB(self::getClassName(), $registrato);
    }

    public static function load(string  $value, string $row)
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $value, $row);

        if ($result == null || sizeof($result) == 0)
        {
            return null;
        }

        $row = $result[0];
        $nome = $row["nome"];
        $cognome = $row["cognome"];
        $username = $row["username"];
        $email = $row["email"];
        $password = $row["password"];
        $isAdmin = $row["isAdmin"];

        return new EPersona($nome, $cognome, $username, $email, $password, $isAdmin);

    }

    public static function update($value,$row,$newvalue,$newrow): bool {
    $db = FDatabase::getInstance();
    if($db->updateTheDB(self::getClassName(), $value, $row, $newvalue, $newrow))
    {
        return true;
    }
    return false;
    }

    public static function delete($value, $row): bool {
        $db = FDatabase::getInstance();
        if($db->deleteFromDB(self::getClassName(),$value,$row))
        {
            return true;
        }
        return false;
    }

    /*public static function ricercaPerNomeeCognome ($class, string $nome, string $cognome)//non credo che vada messa e neanche che funzioni
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDBDebole($class::getClassName(), $nome,"nome", $cognome,"cognome" );

        if ($result == null || sizeof($result) == 0)
        {
            return null;
        }

        $return = array();
        foreach ($result as $row)
        {
            array_push($return, self::fromRow($row));
        }

        return $return;
    }*/

    public static function ricercaPerUsername($class, ERegistrato $registrato)
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB($class, $registrato, "username");

        if ($result == null || sizeof($result) == 0)
        {
            return null;
        }

        $return = array();
        foreach ($result as $row)
        {
            array_push($return, self::fromRow($row));
        }

        return $return;
    }

    public static function ricercaPerId($class, $registrato)
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB($class, $registrato, "idRegistrato");

        if ($result == null || sizeof($result) == 0)
        {
            return null;
        }

        $return = array();
        foreach ($result as $row)
        {
            array_push($return, self::fromRow($row));
        }

        return $return;


    }

    public static function ricercaPerCampo($campo, $id)
    {
        $registrato = null;
        $db=FDatabase::getInstance();
        $result=$db->loadDB(static::getClass(), $campo, $id);
        $row = $db->interestedRows(static::getClass(), $campo, $id);
        if(($result!=null) && ($row == 1)) {
            $registrato=new ERegistrato($result['nome'],$result['cognome'],$result['username'], $result['email'], $result['password'],$result['state']);

        }
        else {
            if(($result!=null) && ($row > 1)){
                $registrato = array();
                for($i=0; $i<count($result); $i++){
                    $registrato[]=new ERegistrato($result[$i]['nome'],$result[$i]['cognome'],$result[$i]['username'], $result[$i]['email'], $result[$i]['password'],$result[$i]['state']);

                }
            }
        }
        return $registrato;
    }

    public static function ricercaPerStringa($string){
        $registrato = null;
        $ricerca = null;
        $pieces = explode(" ", $string);
        $lastElement = end($pieces);
        if ($pieces[0] == $lastElement) {
            $ricerca = 'nome';
        }
        $db=FDatabase::getInstance();
        list ($result, $row)=$db->utentiByString($pieces, $ricerca);
        if(($result!=null) && ($row == 1)) {
            $utente=new ERegistrato($result['nome'],$result['cognome'],$result['username'], $result['email'], $result['password'],$result['state']);
        }
        else {
            if(($result!=null) && ($row > 1)){
                $registrato = array();
                for($i=0; $i<count($result); $i++){
                    $utente[]=new ERegistrato($result[$i]['nome'],$result[$i]['cognome'],$result[$i]['username'], $result[$i]['email'], $result[$i]['password'],$result[$i]['state']);
                }
            }
        }
        return $registrato;
    }

    public static function exist($field, $id){
        $db=FDatabase::getInstance();
        $result=$db->existDB(static::getClass(), $field, $id);
        if($result!=null)
            return true;
        else
            return false;
    }





}