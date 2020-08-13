<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DomainCheckControllerTest extends TestCase
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
        $response = $this->ajaxGet(route('ajax.domain-checks.index') . "?domain_id=1");
        $response->assertSuccessful();
    }

    public function testStore()
    {
        $domainCheckData = [
            'domain_id' => 1,
        ];

        $response = $this->ajaxPost(route('ajax.domain-checks.store', $domainCheckData));
        $response->assertSessionHasNoErrors();
        $response->assertSuccessful();

        $this->assertDatabaseHas('domain_checks', $domainCheckData);
    }
}
