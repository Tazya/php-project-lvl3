<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    public static function normalizeUrl($url)
    {
        $urlComponents = parse_url($url);
        $result = "{$urlComponents['scheme']}://{$urlComponents['host']}";
        return $result;
    }
}
