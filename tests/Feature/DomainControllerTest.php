<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class DomainControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get(route('domains.index'));
        $response->assertOk();
    }

    public function testShow()
    {
        $currentDateTime = Carbon::now();
        $domainData = [
            'name' => Faker::create()->url,
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime
        ];

        $id = DB::table('domains')->insertGetId($domainData);
        $response = $this->get(route('domains.show', $id));
        $response->assertOk();
    }

    public function testStore()
    {
        $bodyHtml = file_get_contents("tests/Fixtures/body.html");

        Http::fake([
            '*' => Http::response($bodyHtml),
        ]);

        $domainData = [
            'name' => Faker::create()->url,
        ];

        $response = $this->post(route('domains.store', $domainData));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('domains', $domainData);
    }
}
