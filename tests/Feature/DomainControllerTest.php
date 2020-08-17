<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DomainControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $sqlDomain =
        "CREATE TABLE domains (
            id INTEGER NOT NULL PRIMARY KEY,
            name character varying(255) NOT NULL,
            created_at timestamp(0),
            updated_at timestamp(0)
        )";

        $sqlDomainCheck =
        "CREATE TABLE domain_checks (
            id INTEGER NOT NULL PRIMARY KEY,
            domain_id bigint NOT NULL,
            status_code integer,
            h1 character varying(255),
            keywords character varying(255),
            description text,
            created_at timestamp(0),
            updated_at timestamp(0),
            FOREIGN KEY (domain_id)
                REFERENCES domains (id)
        )";

        DB::statement($sqlDomain);
        DB::statement($sqlDomainCheck);

        $currentDateTime = Carbon::now();
        $domainData = [
            'name' => "https://" . Str::random(5) . ".com",
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime
        ];
        DB::table('domains')->insert($domainData);
    }

    public function testIndex()
    {
        $response = $this->get(route('domains.index'));
        $response->assertOk();
    }

    public function testShow()
    {
        $currentDateTime = Carbon::now();
        $domainData = [
            'name' => "https://" . Str::random(5) . ".com",
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime
        ];
        DB::table('domains')->insert($domainData);

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
