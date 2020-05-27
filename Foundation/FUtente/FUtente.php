<?php


class FUtente implements Foundation
{
    private static string $className = "FUtente";
    private static string $tableName = "Utenti";
    private static string $valuesName = "(:id,:username,:email,:nome,:cognome,:password,:isAdmin,:isBanned)";

    private bool $isAdmin;
    private int $idUtente;

    /**
     * @return int
     */
    public function getIdUtente(): int
    {
        return $this->idUtente;
    }

    /**
     * @param int $idUtente
     */
    public function setIdUtente(int $idUtente): void
    {
        $this->idUtente = $idUtente;
    }


    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    public function __construct() {}

    public static function associate(PDOStatement $sender, $utente){
        if ($utente instanceof EUtente) {
            $sender->bindValue(':id', NULL, PDO::PARAM_INT);
            $sender->bindValue(':username', $utente->getUsername(), PDO::PARAM_STR);
            $sender->bindValue(':email', $utente->getEmail(), PDO::PARAM_STR);
            $sender->bindValue(':nome', $utente->getNome(), PDO::PARAM_STR);
            $sender->bindValue(':cognome', $utente->getCognome(), PDO::PARAM_STR);
            $sender->bindValue(':password', $utente->getPassword(), PDO::PARAM_STR);
            $sender->bindValue(':isAdmin', $utente instanceof EAdmin, PDO::PARAM_BOOL);
            $sender->bindValue(':isBanned', $utente->getIsBanned(), PDO::PARAM_BOOL);
        } else {
            die("Not a user!!");
        }
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

    public static function save(EUtente $utente)
    {
        $db = FDatabase::getInstance();
        $id = $db->saveToDB(self::getClassName(), $utente);
        $utente->setId($id);
    }

    public static function load(string  $value, string $row)
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB(self::getClassName(), $value, $row);
        if ($result == null || sizeof($result) == 0)
        {
            return null;
        }

        return self::parseResult($result)[0];
    }

    public static function update($value, $row, $newvalue, $newrow): bool {
        $db = FDatabase::getInstance();
        if($db->updateTheDB(self::getClassName(), $value, $row, $newvalue, $newrow))
        {
            return true;
        }
        return false;
    }

    public static function delete($value, $row): bool {
        $db = FDatabase::getInstance();
        if($db->deleteFromDB(self::getClassName(), $value, $row))
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

    public static function ricercaPerUsername($class, EUtente $utente)
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB($class, $utente, "username");

        if ($result == null || sizeof($result) == 0)
        {
            return null;
        }

        return self::parseResult($result);
    }

    public static function ricercaPerId($class, EUtente $utente)
    {
        $db = FDatabase::getInstance();
        $result = $db->loadFromDB($class, $utente, "idUtente");

        if ($result == null || sizeof($result) == 0)
        {
            return null;
        }

        return self::parseResult($result);
    }

//    public static function ricercaPerCampo($campo, $id)
//    {
//        $registrato = null;
//        $db=FDatabase::getInstance();
//        $result=$db->loadDB(static::getClass(), $campo, $id);
//        $row = $db->interestedRows(static::getClass(), $campo, $id);
//        if(($result!=null) && ($row == 1)) {
//            $registrato=new ERegistrato($result['nome'],$result['cognome'],$result['username'], $result['email'], $result['password'],$result['state']);
//
//        }
//        else {
//            if(($result!=null) && ($row > 1)){
//                $registrato = array();
//                for($i=0; $i<count($result); $i++){
//                    $registrato[]=new ERegistrato($result[$i]['nome'],$result[$i]['cognome'],$result[$i]['username'], $result[$i]['email'], $result[$i]['password'],$result[$i]['state']);
//
//                }
//            }
//        }
//        return $registrato;
//    }
//
//    public static function ricercaPerStringa($string){
//        $registrato = null;
//        $ricerca = null;
//        $pieces = explode(" ", $string);
//        $lastElement = end($pieces);
//        if ($pieces[0] == $lastElement) {
//            $ricerca = 'nome';
//        }
//        $db=FDatabase::getInstance();
//        $result = $db->utentiByString($pieces, $ricerca);
//
//        return self::parseResult($result);
//    }

    private static function parseResult(array $result): array
    {
        $return = [];

        foreach ($result as $row) {
            $id = $row["id"];
            $nome = $row["nome"];
            $cognome = $row["cognome"];
            $username = $row["username"];
            $email = $row["email"];
            $password = $row["password"];
            $isAdmin = $row["isAdmin"];
            $isBanned = $row["isBanned"];

            if ($isAdmin)
            {
                $admin = new EAdmin($nome, $cognome, $username, $email, $password, $isBanned);
                $admin->setId($id);
                array_push($return, $admin);
            }
            elseif ($username != null && $username != "")
            {
                $reg =  new ERegistrato($nome, $cognome, $username, $email, $password, $isBanned);
                $reg->setId($id);
                array_push($return, $reg);
            }
            else
            {
                $nreg = new ENonRegistrato($nome, $cognome, $username, $email, $password, $isBanned);
                $nreg->setId($id);
                array_push($return, $nreg);
            }
        }

        return $return;
    }
}