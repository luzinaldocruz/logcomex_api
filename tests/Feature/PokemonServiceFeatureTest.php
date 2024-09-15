<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PokemonServiceFeatureTest extends TestCase
{
    public function testGetPokemonInfoReturnsSuccess()
    {
        $response = $this->get('/api/pokemon/pikachu');

        $response->assertStatus(200)
            ->assertJson([
                'name' => 'Pikachu',
                'types' => 'electric',
                'height' => 40,
                'weight' => 6.0,
            ]);
    }
}
