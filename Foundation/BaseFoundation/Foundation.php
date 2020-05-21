<?php

interface Foundation
{
    public static function associate(PDOStatement $sender, $object);
    public static function load(string $value, string $row);
    public static function update($value, $row, $newvalue, $newrow);
    public static function delete($value, $row);
}