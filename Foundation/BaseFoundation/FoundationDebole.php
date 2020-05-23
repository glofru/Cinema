<?php

interface FoundationDebole
{
    public static function associate(PDOStatement $sender, $object1, $object2);
    public static function load(string $value, string $row);
    public static function update($value, $row, $value2, $row2, $newvalue, $newrow);
    public static function delete($value, $row, $value2, $row2);
}