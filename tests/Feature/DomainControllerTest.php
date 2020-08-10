<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Domain;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DomainControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $sql =
        "CREATE TABLE domains (
            id INTEGER NOT NULL PRIMARY KEY,
            name character varying(255) NOT NULL,
            created_at timestamp(0),
            updated_at timestamp(0)
        )";

        DB::statement($sql);
    }

    public function testIndex()
    {
        $response = $this->get(route('domains.index'));
        $response->assertOk();
    }

    public function testShow()
    {
        $currentDateTime = Carbon::now();
        $this->domainData = [
            'name' => "https://" . Str::random(5) . ".com",
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime
        ];
        DB::table('domains')->insert($this->domainData);

        $response = $this->get(route('domains.show', 1));
        $response->assertOk();
    }

    public function testStore()
    {
        $domainData = [
            'name' => "https://" . Str::random(5) . ".com",
        ];

        $response = $this->post(route('domains.store', $domainData));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('domains', $domainData);
    }
}
