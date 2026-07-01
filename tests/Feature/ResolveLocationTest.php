<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\City;
use App\Models\State;
use Tests\TestCase;

class ResolveLocationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Confirma que o onboarding resolve UF e cidade usando as tabelas locais.
     */
    public function test_it_resolves_address_location_ids_from_local_tables(): void
    {
        State::create([
            'id' => 25,
            'country_id' => 26,
            'name' => 'São Paulo',
            'acronym' => 'SP',
            'code' => 35,
            'cuf' => 35,
            'status' => 1,
            'created_by' => 1,
        ]);

        City::create([
            'id' => 5270,
            'state_id' => 25,
            'name' => 'São Paulo',
            'code_ibge' => 3550308,
            'status' => 1,
            'created_by' => 1,
        ]);

        $response = $this->getJson('/resolve-location?state_id=25&city=Sao%20Paulo');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'company_state_id' => 25,
                'company_city_id' => 5270,
            ]);
    }
}
