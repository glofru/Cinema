<?php


class CMain
{
    public function run(string $url)
    {
        $parsed_url = parse_url($url);
        $path = $parsed_url["path"];

        
    }
}