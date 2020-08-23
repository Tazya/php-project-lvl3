<?php

namespace App;

use DiDom\Document;

class DomainCheck
{
    public static function parseSeoDataFromHtml($html)
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
}
