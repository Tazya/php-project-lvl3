<?php

namespace App;

use DiDom\Document;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class DomainCheck
{
    public static function getPageInfo($html)
    {
        $document = new Document($html);

        $h1Element = $document->first('h1');
        $keywordsElement = $document->first('meta[name=keywords]');
        $descriptionElement = $document->first('meta[name=description]');

        $h1 = $h1Element ? $h1Element->text() : null;
        $keywords = $keywordsElement ? $keywordsElement->getAttribute('content') : null;
        $description = $descriptionElement ? $descriptionElement->getAttribute('content') : null;

        return compact('h1', 'keywords', 'description');
    }

    public static function makeCheck($domainId)
    {
        $domain = DB::table('domains')->find($domainId);
        $response = Http::get($domain->name);

        $currentDate = Carbon::now();

        $seoData = self::getPageInfo($response->body());

        $domainCheckData = [
            'domain_id' => $domainId,
            'status_code' => $response->status(),
            'created_at' => $currentDate,
            'updated_at' => $currentDate,
        ];

        DB::table('domain_checks')->insert(array_merge($domainCheckData, $seoData));
    }
}
