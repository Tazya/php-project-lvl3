<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DiDom\Document;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class DomainCheckController extends Controller
{
    public function store($id)
    {
        $domain = DB::table('domains')->find($id);
        $response = Http::get($domain->name);

        $currentDate = Carbon::now();

        $seoData = $this->getPageInfo($response->body());

        $domainCheckData = [
            'domain_id' => $id,
            'status_code' => $response->status(),
            'created_at' => $currentDate,
            'updated_at' => $currentDate,
        ];

        DB::table('domain_checks')->insert(array_merge($domainCheckData, $seoData));
        flash("Website has been checked!")->success();

        return redirect()->route('domains.show', compact('id'));
    }

    private function getPageInfo($html)
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
