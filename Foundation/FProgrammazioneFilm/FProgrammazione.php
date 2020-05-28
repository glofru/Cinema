<?php


class FProgrammazione implements Foundation
{
    private static string $className = "FProgrammazione";
    private static string $tableName = "Programmazione";
    private static string $valuesName = "(:id,:data,:ora,:numerosala,:idFilm)";

    public function __construct() {}

    public static function associate(PDOStatement $sender, $proiezione) {
        if ($proiezione instanceof EProiezione) {
            $sender->bindValue(':id', NULL, PDO::PARAM_INT);
            $sender->bindValue(':data',$proiezione->getDataSQL(),PDO::PARAM_STR);
            $sender->bindValue(':ora',$proiezione->getOra(),PDO::PARAM_STR);
            $sender->bindValue(':numerosala',$proiezione->getSala()->getNumeroSala(),PDO::PARAM_INT);
            $sender->bindValue(':idFilm', $proiezione->getFilm()->getId(), PDO::PARAM_INT);
        } else {
            die("Not a projection!!");
        }
    }

    public static function associate(PDOStatement $sender, $object)
    {
        // TODO: Implement associate() method.
    }

    public static function load(string $value, string $row)
    {
        // TODO: Implement load() method.
    }

    public static function update($value, $row, $newvalue, $newrow)
    {
        // TODO: Implement update() method.
    }

    public static function delete($value, $row)
    {
        // TODO: Implement delete() method.
    }
}