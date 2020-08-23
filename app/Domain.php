<?php

namespace App;

class Domain
{
    public static function normalizeUrl($url)
    {
        $urlComponents = parse_url($url);
        $result = "{$urlComponents['scheme']}://{$urlComponents['host']}";
        return $result;
    }
}
