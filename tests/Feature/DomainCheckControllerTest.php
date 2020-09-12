<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class DomainCheckControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $currentDateTime = Carbon::now();
        $domainData = [
            'name' => Faker::create()->url,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime
        ];

        $this->domainId = DB::table('domains')->insertGetId($domainData);
    }

    public function testStore()
    {
        $bodyHtml = file_get_contents("tests/Fixtures/body.html");
        Http::fake([
            '*' => Http::response($bodyHtml),
        ]);

        $domainCheckData = [
            'domain_id' => $this->domainId,
            'h1' => 'Site Header',
            'keywords' => 'document,site',
        ];

        $response = $this->post(route('domain-checks.store', $this->domainId));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('domain_checks', $domainCheckData);
    }
}
